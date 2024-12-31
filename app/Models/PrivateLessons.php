<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use JoisarJignesh\Bigbluebutton\Facades\Bigbluebutton;
use BigBlueButton\Parameters\GetRecordingsParameters;


class PrivateLessons extends Model
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;
    public static $index = 0;

    protected $fillable = [
        'id',
        'category_id',
        'teacher_id',
        'student_id',
        'time_type',
        'user_package_id', // user_package_id
        'meeting_type',
        'price',
        'meeting_date',
        'time_form',
        'time_to',
        'meeting_link',
        'status',
        'accept_group',
        'student_no'
    ];

    public $translatedAttributes = ['title', 'description'];

    // title
    function title() {
        return $this->category->name;
    }
    public function createTranslation(Request $request)
    {
        foreach (locales() as $key => $language) {
            foreach ($this->translatedAttributes as $attribute) {
                if ($request->get($attribute . '_' . $key) != null && !empty($request->$attribute . $key)) {
                    $this->{$attribute . ':' . $key} = $request->get($attribute . '_' . $key);
                }
            }
            $this->save();
        }
        return $this;
    }

    public function requests(): HasMany
    {
        return $this->hasMany(PrivateLessonsRequest::class,'private_lesson_id');
    }
    public function category()
    {
        return $this->hasOne(Category::class, 'value', 'category_id')
            ->where('parent', 'course_categories');
    }

    public function teacher()
    {
        return $this->hasOne('App\Models\User', 'id', 'teacher_id')->withDefault(['name' => 'no_teacher']);
    }

    public function student()
    {
        return $this->hasOne('App\Models\User', 'id', 'student_id')->withDefault(['name' => ' ']);
    }


    /**
     * Get the user_package that owns the PrivateLessons
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_package(): BelongsTo
    {
        return $this->belongsTo(UserPackages::class, 'user_package_id');
    }

    public function earnings()
    {
        return $this->hasOne('App\Models\Balances', 'transaction_id', 'id');
    }

    public function scopeGetStudentPrivateLessons($query, $id)
    {
        return $query->where([['student_id', $id]]);
    }

    public function scopeActiveLessons($query)
    {
        return $query->where('student_id', null)
            ->where('status', 'pending')
            ->where(function ($query) {
                $query->where('meeting_date', '>', now()->toDateString())
                    ->orWhere(function ($query) {
                        $query->whereDate('meeting_date', now())
                            ->where('time_form', '>=', now()->format('H:i:s'));
                    });
            });
    }

    public function getDateWithFormat()
    {
        $day_name = getDayName($this->meeting_date);
        $day_num = getCustomDateFormate($this->meeting_date, 'd');
        $month_name = getMonthName($this->meeting_date);

        return $day_name . ' ' . $day_num . ' ' . $month_name . ' - ' . $this->start_time;

    }

    public function scopeFilterByDate($query, $fromDate, $toDate)
    {
        if ($fromDate) {
            $query->whereDate('meeting_date', '>=', $fromDate);
        }
        if ($toDate) {
            $query->whereDate('meeting_date', '<=', $toDate);
        }
    }

    public function scopeFilterByStudent($query, $studentId)
    {
        if ($studentId) {
            $query->where('student_id', $studentId);
        }
    }

    public function scopeFilterByCategory($query, $categoryId)
    {
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
    }

    public function scopeFilterByStatus($query, $status)
    {
        if ($status) {
            $query->where('status', $status);
        }
    }


    public function canStartMeeting()
    {
        // return true;
        $check_date = false;

        $date1 = Carbon::createFromFormat("Y-m-d", $this->meeting_date)->format("Y-m-d");

        $date2 = Carbon::createFromFormat("Y-m-d", date("Y-m-d"))->format("Y-m-d");

        $time_now = Carbon::createFromFormat("H:i:s", date("H:i:s"));

        $start_time = Carbon::createFromFormat("H:i:s", $this->time_form);

        $end_time = Carbon::createFromFormat("H:i:s", $this->time_to);

        if ($date1 == $date2) {
            if ($end_time > $time_now && $start_time < $time_now) {

                $check_date = true;
            }
        }

        return $check_date;
    }

    public function meeting()
    {

        return $this->hasOne(PrivateLessonMeeting::class, 'private_lesson_id', 'id');

    }

    public function getRecording()
    {
        $link = "";
        $meeting_id = 'meeting_id_' . $this->id;
        // if (env("APP_ENV") != "local") {
        $link = \Bigbluebutton::getRecordings([
            "meetingID" => $meeting_id,
            //'meetingID' => ['tamku','xyz'], //pass as array if get multiple recordings
            //'recordID' => 'a3f1s',
            //'recordID' => ['xyz.1','pqr.1'] //pass as array note :If a recordID is specified, the meetingID is ignored.
            // 'state' => 'any' // It can be a set of states separate by commas
        ]);
        // }

        return $link;
    }


    public function format()
    {
        $i = 0;
        $user = auth()->user();
        if ($user && $user->country) {
            $hour_price = ceil($user->country->currency_exchange_rate * $this->teacher->hour_price);
            $half_hour_price = ceil($user->country->currency_exchange_rate * $this->teacher->half_hour_price);
            $currency = $user->country->currency_name;
        } else {
            $hour_price = $this->teacher->hour_price;
            $half_hour_price = $this->teacher->half_hour_price;
            $currency = __('currency');
        }

        return [
            'currency' => $currency,
            'index' => self::$index++,
            'day_number' => Carbon::parse($this->meeting_date)->dayOfWeek,
            'type_id' => @$this->id,
            'category_name' => @$this->category->name,
            'meeting_type' => @$this->meeting_type,
            'start' => @$this->meeting_date,
            'time_from' => Carbon::parse(@$this->time_form)->format('h:i A'),
            'time_to' => Carbon::parse(@$this->time_to)->format('h:i A'),
            'accept_group' => 1,
            'online_price' => ($this->time_type == 'half_hour') ? (@$half_hour_price ?? 0) : (@$hour_price ?? 0),
            'online_discount' => "",
            'offline_price' => ($this->time_type == 'half_hour') ? (@$half_hour_price ?? 0) : (@$hour_price ?? 0),
            'offline_discount' => "",
            'online_group_min_no' => @$this->teacher->min_student_no ?? 0,
            'online_group_max_no' => @$this->teacher->max_student_no ?? 0,
            'online_group_price' => ($this->time_type == 'half_hour') ? (@$half_hour_price ?? 0) : (@$hour_price ?? 0),

            'offline_group_min_no' => @$this->teacher->min_student_no ?? 0,
            'offline_group_max_no' => @$this->teacher->max_student_no ?? 0,
            'offline_group_price' => ($this->time_type == 'half_hour') ? (@$half_hour_price ?? 0) : (@$hour_price ?? 0),
            'status' => @$this->status,

            // 'accept_group'     => @$this->category->prices[0]->accept_group,
            // 'online_price'     => @$this->category->prices[0]->online_price ?? 0,
            // 'online_discount'  => @$this->category->prices[0]->online_discount ?? 0,
            // 'offline_price'    => @$this->category->prices[0]->offline_price ?? 0,
            // 'offline_discount' => @$this->category->prices[0]->offline_discount ?? 0,
            // 'online_group_min_no'     => @$this->category->prices[0]->online_group_min_no ?? 0,
            // 'online_group_max_no'     => @$this->category->prices[0]->online_group_max_no ?? 0,
            // 'online_group_price'      => @$this->category->prices[0]->online_group_price ?? 0,

            // 'offline_group_min_no'    => @$this->category->prices[0]->offline_group_min_no ?? 0,
            // 'offline_group_max_no'    => @$this->category->prices[0]->offline_group_max_no ?? 0,
            // 'offline_group_price'     => @$this->category->prices[0]->offline_group_price ?? 0,

        ];

    }

    public function getPrice($type = "single", $meeting_type = "online", $time_type = "hour")
    {
        // if ($type == 'single') {
        //     $price = $meeting_type == 'online' ? @$this->category->prices[0]->online_price : @$this->category->prices[0]->offline_price;
        // }
        // if ($type == 'group') {
        //     $price = $meeting_type == 'online' ? @$this->category->prices[0]->online_group_price : @$this->category->prices[0]->offline_group_price;
        // }
        if ($time_type == 'half_hour') {
            $price = $this->teacher->hour_price / 2;
        } else {
            $price = $this->teacher->hour_price;
        }

        if ($price == null) {
            $price = 0;
        }

        /*$user = auth()->user();
        if($user && $user->country) {
            $price = ceil($user->country->currency_exchange_rate*$price);
        } else {
            $price = $price;
        }*/
        return $price;
    }

    public function getPriceWithCurrency($type = "single", $meeting_type = "online", $time_type = "hour")
    {
        // if ($type == 'single') {
        //     $price = $meeting_type == 'online' ? @$this->category->prices[0]->online_price : @$this->category->prices[0]->offline_price;
        // }
        // if ($type == 'group') {
        //     $price = $meeting_type == 'online' ? @$this->category->prices[0]->online_group_price : @$this->category->prices[0]->offline_group_price;
        // }

        if ($time_type == 'half_hour') {
            $price = $this->teacher->half_hour_price;
        } else {
            $price = $this->teacher->hour_price;
        }

        if ($price == null) {
            $price = 0;
        }

        $user = auth()->user();
        if ($user && $user->country) {
            $price = ceil($user->country->currency_exchange_rate * $price) . " " . $user->country->currency_name;
        } else {
            $price = $price . ' ' . __('currency') . ' ';
        }
        return $price;
    }

    public function getFirstPriceWithCurrency()
    {
        $user = $this->teacher;
        $firstPrice = $this->earnings->amount_before_commission;
        if ($firstPrice) {
            if ($user && $user->country) {
                $firstPrice = ceil($user->country->currency_exchange_rate * $firstPrice) . " " . $user->country->currency_name;
            } else {
                $firstPrice = $firstPrice . ' ' . __('currency') . ' ';
            }
        }
        return $firstPrice;
    }

    public function getEarningWithCurrency()
    {
        $user = $this->teacher;
        $earning = $this->earnings->amount;
        if ($earning) {
            if ($user && $user->country) {
                $earning = ceil($user->country->currency_exchange_rate * $earning) . " " . $user->country->currency_name;
            } else {
                $earning = $earning . ' ' . __('currency') . ' ';
            }
        }
        return $earning;
    }

    // public function scopeFilterByPriceRange($query, $priceFrom, $priceTo)
    // {
    //     return $query->whereHas('category.prices', function ($priceQuery) use ($priceFrom, $priceTo) {
    //         $priceQuery->where(function ($priceWhere) use ($priceFrom, $priceTo) {
    //             $priceWhere->where(function ($singlePrice) use ($priceFrom, $priceTo) {
    //                 $singlePrice->whereBetween('online_price', [$priceFrom, $priceTo]);
    //             })->orWhere(function ($singlePrice) use ($priceFrom, $priceTo) {
    //                 $singlePrice->whereBetween('offline_price', [$priceFrom, $priceTo]);
    //             })->orWhere(function ($singlePrice) use ($priceFrom, $priceTo) {
    //                 $singlePrice->whereBetween('online_group_price', [$priceFrom, $priceTo]);
    //             })->orWhere(function ($singlePrice) use ($priceFrom, $priceTo) {
    //                 $singlePrice->whereBetween('offline_group_price', [$priceFrom, $priceTo]);
    //             });
    //         });
    //     });
    // }


    public function getMinStudentsNo($meeting_type = "online")
    {
        // $student_no = $meeting_type == 'online' ? @$this->category->prices[0]->online_group_min_no : @$this->category->prices[0]->offline_group_min_no;

        $student_no = $this->teacher->min_student_no;

        return $student_no;
    }

    public function getMaxStudentsNo($meeting_type = "online")
    {
        // $student_no = $meeting_type == 'online' ? @$this->category->prices[0]->online_group_max_no : @$this->category->prices[0]->offline_group_max_no;

        $student_no = $this->teacher->max_student_no;

        return $student_no;
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Ratings', 'sourse_id', 'id')->where(
            [
                ['is_active', 1],
                ['sourse_type', Ratings::PRIVATE_LESSON]
            ]
        );
    }

    public function getRate()
    {
        $count_rate = count($this->reviews);
        $total_rate = $this->reviews()->sum('rate');

        return [
            'count_rate' => $count_rate,
            'total_rate' => $total_rate,
        ];
    }
    public function ratings()
    {
        return $this->hasMany('App\Models\Ratings', 'sourse_id', 'id');
    }

    function generateSimplePassword($length = 8) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomPassword = '';

        // Generate the password
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomPassword;
    }

    public function createLiveSession ($type = 'web'){
        $attendeePW = $this->generateSimplePassword(8);
        $moderatorPW = $this->generateSimplePassword(8);
        $meeting_id = "course_session_with_id_".$this->id.time();
        $this->meeting_id = $meeting_id;

        Bigbluebutton::create([
            'meetingID'      => $meeting_id,
            'meetingName'    => $this->meeting_id,
            'autoStartRecording' => true,
            'allowStartStopRecording' => false,
            'record'         => true,
            'attendeePW'     => $attendeePW,
            'moderatorPW'    => $moderatorPW,
            'endCallbackUrl' => route('user.meeting.finished' , $this->id),
            'logoutUrl'      => route('user.meeting.finished' , [$this->id , auth($type)->id()]),
        ]);
        $this->public_password = $attendeePW;
        $this->private_password = $moderatorPW;
        $url =  Bigbluebutton::join([
            'meetingID' => $this->meeting_id,
            'userName'  => auth($type)->user()->name,
            'role'      => 'MODERATOR',
            'password'  => $moderatorPW
        ]);
        $this->meeting_link = $url;

        $this->save();

        return $url;
    }

    public function joinLiveSessionV2($type = 'web') {
        try {


            if(auth($type)->user()->role == 'student'){

                $response = Bigbluebutton::join([
                    'meetingID' => $this->meeting_id,
                    'userName' => auth($type)->user()->name,
                    'password' => $this->public_password,

                ]);
            }else{
                $response =  Bigbluebutton::join([
                    'meetingID' => $this->meeting_id,
                    'userName'  => auth($type)->user()->name,
                    'role'      => 'MODERATOR',
                    'password'  => $this->private_password
                ]);
            }

            return $response;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not join session.'], 500);
        }
    }

}
