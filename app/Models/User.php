<?php

namespace App\Models;

use App\Http\Requests\Front\joinAsMarketRequestRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\SendInitPasswordNotification;
use App\Notifications\SendVerificationCodeNotification;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements MustVerifyEmail

{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    //  add by 'manually','admin','excel'
     const ADD_BY_ADMIN='admin';
     const ADD_BY_EXCEL='excel';

    //type user
     const STUDENTS='student';
     const LECTURER='lecturer';
     public const MARKETER='marketer';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'role',
        'password',
        'password_c',
        'validation_code',
        'validation_at',
        'is_validation',
        'last_send_validation_code',
        'gender',
        'dob',
        'code_country',
        'slug_country',
        'country_id',
        'city',
        'image',
        'device_token',
        'belongs_to_awael',
        'mother_lang_id',
        'system_commission',
        'system_commission_reason',
        'can_add_half_hour',
        'half_hour_price',
        'hour_price',
        'min_student_no',
        'max_student_no',
        'last_login_at',
        'market_id',
        'coupon_id',
        'material_id',
        'session_token'
    ];

    public function studentSubscribedSessions()
    {
        return $this->hasMany(CourseSessionSubscription::class,'student_id','id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sendVerificationCode()
    {
        $code = substr(sprintf("%06d", mt_rand(1, 999999)), 0, 6);
        $this->validation_code = $code;
        $this->last_send_validation_code = Carbon::now();
        $this->update();

        sendOtpToWhatsapp($this->code_country.$this->mobile,$this->validation_code);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    // Relations
        public function lecturerSetting()
        {
            return $this->hasOne('App\Models\LecturerSetting', 'user_id');
        }
        public function lecturerExpertise()
        {
            return $this->hasMany('App\Models\LecturerExpertise', 'user_id');
        }
        public function reviews()
        {
            return $this->hasMany('App\Models\Ratings', 'sourse_id', 'id')->where(
                [
                    ['is_active',1],
                    ['sourse_type',Ratings::USER]
                ]
            );
        }
        public function ratings()
        {
            return $this->hasMany('App\Models\Ratings', 'sourse_id', 'id');
        }
        public function teacherPrivateLessons()
        {
            return $this->hasMany('App\Models\PrivateLessons', 'teacher_id');
        }

        public function LecturerTimeTableAvailable()
        {
            return $this->hasMany('App\Models\LecturerTimeTable', 'user_id')->whereDoesntHave('private_lessons_time');
        }

        public function courses()
        {
            return $this->hasMany(UserCourse::class);
        }
        public function lecturerCourses()
        {
            return $this->hasMany(Courses::class, 'user_id', 'id');
        }
        public function categories($type)
        {
            return $this->hasMany(UserCategory::class)->where('category_type', $type);
        }
        public function materials() {   // used for Lecturer
            return $this->categories('joining_course');
        }
        public function languages() {   // used for Lecturer
            return $this->categories('course_languages');
        }
        public function privateLessons()
        {
            return $this->hasMany(PrivateLessons::class, 'student_id', 'id');
        }
        public function chats() {
            return Chat::where('initiator_id',$this->id)->orWhere('partner_id', $this->id);
        }
        public function chatsOrderedByLatestMessage()
        {
            $latestMessageSubquery = ChatMessages::selectRaw('MAX(created_at) as latest_message_created_at, chat_id')
                ->groupBy('chat_id');

            return Chat::where(function ($query) {
                    $query->where('initiator_id', $this->id)
                        ->orWhere('partner_id', $this->id);
                })
                ->leftJoinSub($latestMessageSubquery, 'latest_messages', function ($join) {
                    $join->on('chats.id', '=', 'latest_messages.chat_id');
                })
                ->orderByDesc('latest_messages.latest_message_created_at');
        }

        public function country()
        {
            return $this->hasOne(Category::class, 'value', 'country_id')->where('parent', 'countries');
        }
        public function motherLang() {   // used for Lecturer
            return $this->hasOne(Category::class, 'value', 'mother_lang_id')->where('parent', 'course_languages');
        }

    // End Relations




    // Scopes


        public function scopeActive($q)
        {
            return $q->where('is_validation', 1)->where('is_block', 0);
        }

        public function scopeHasCoursesOrPrivateLessons($query)
        {
            return $query->whereHas('courses')
                ->orWhereHas('privateLessons');
        }

        public function scopeChatsWithMessages()
        {
            return Chat::whereHas('messages', function ($query) {
                $query->where('sender_id', $this->id);
            });
        }

        public function scopeRelatedStudents($query)
        {
            return $query->whereHas('courses', function ($q) {
                $q->where('lecturer_id', $this->id);
            })->orWhereHas('privateLessons', function ($q) {
                $q->where('teacher_id', $this->id);
            });
        }

    // End Scopes


    // Functions for Both LECTURERS and STUDENTS

    // End Functions for Both LECTURERS and STUDENTS

    // Functions for STUDENTS

        public function CourseCount()
        {
            return $this->courses()->count();
        }

        public function recordedCourseCount()
        {
            return $this->courses()->whereHas('course', function ($query) {
                $query->where('type', 'recorded');
            })->count();
        }

        public function liveCourseCount()
        {
            return $this->courses()->whereHas('course', function ($query) {
                $query->where('type', 'live');
            })->count();
        }

        public function privateLessonsCount()
        {
            return $this->privateLessons()->count();
        }

        public function LecturerRelatedCoursesCount($lecturerId)
        {
            return $this->courses()->whereHas('course', function ($query) use($lecturerId) {
                $query->where('lecturer_id', $lecturerId);
            })->count();
        }

        public function LecturerRelatedLessonsCount($lecturerId)
        {
            return privateLessons::where('teacher_id', $lecturerId)
                ->where('student_id', $this->id)
                ->count();
        }

    // End Functions for STUDENTS

    // Functions for LECTURERS

        public function LecturerCoursesCount()
        {
            return $this->lecturerCourses()->count();
        }

        public function getRating()
        {
            $ratings_sum = $this->reviews()
                ->sum('rate');

            $ratings_count = $this->getRatingCount();

            if ($ratings_count == 0) {
                return 0;
            }

            return round(fdiv($ratings_sum, $ratings_count));
        }

        public function getRatingCount()
        {
            return $this->reviews()->count();
        }

        /**
         * Get the join_request that owns the User
         *
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function join_request()
        {
            return $this->belongsTo(JoinAsTeacherRequests::class, 'email', 'email')->where('status' , 'acceptable');
        }
    // End Functions for LECTURERS

    // Functions for MARKETER
        /**
         * Get the join_request_marketer that owns the User
         *
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function join_request_marketer()
        {
            return $this->belongsTo(RequestJoinMarketer::class, 'email', 'email')->where('status' , 'acceptable');
        }
    // End Functions for MARKETER

    // Filters

        public function scopeFilter($q, $search)
        {
            if (isset($search['role'])) {
                $role = $search['role'];
                if ($role != '') {
                    $q = $q->where('role', 'like', '%' . $role . '%');
                }
            }

            if (isset($search['user_ids'])) {
                $user_ids = $search['user_ids'];
                if ($user_ids != '') {
                    $q = $q->whereIn('id', $user_ids);
                }
            }



            if (isset($search['name'])) {
                $name = $search['name'];
                $q = $q->where('name', 'like', '%' . $name . '%')->orWhere('email', 'like', '%' . $name . '%');
            }

            return $q;
        }
        public function scopeFilterFromDate($query, $date)
        {
            if ($date) {
                $query->whereHas('privateLessons', function ($q) use ($date) {
                        $q->whereDate('meeting_date', '>=', $date);
                    })->orWhereHas('courses', function ($q) use ($date) {
                        $q->whereHas('course', function ($qq) use ($date) {
                            $qq->where('start_date', '>=', $date);
                        });
                    });
            }
        }

        public function scopeFilterToDate($query, $date)
        {
            if ($date) {
                $query->whereHas('privateLessons', function ($q) use ($date) {
                        $q->whereDate('meeting_date', '<=', $date);
                    })->orWhereHas('courses', function ($q) use ($date) {
                        $q->whereHas('course', function ($qq) use ($date) {
                            $qq->where('start_date', '<=', $date);
                        });
                    });
            }
        }

        public function scopeFilterEmail($query, $email)
        {
            if ($email) {
                $query->where('email', 'like', '%' . $email . '%');
            }
        }


        /*public function scopeFilter($q, $search)
        {
            //return $q->whereHas('translations', function ($q) use ($search) {
                return $q->where('name', 'like', '%' . $search . '%');
            //});
        }*/

        public function scopeFilterByTitle($q, $search)
        {
            //return $q->whereHas('translations', function ($q) use ($search) {
                return $q->where('name', 'like', '%' . $search . '%');
            //});
        }

        public function scopeFilterByMeeting($q, $search)
        {
            return $q->whereHas('teacherPrivateLessons', function ($query) use ($search) {
                if ($search == 'online') {
                    $query->where('meeting_type', 'online');
                } elseif ($search == 'offline') {
                    $query->where('meeting_type', 'offline');
                }elseif ($search == 'both') {
                    $query->where('meeting_type', 'online');
                    $query->orWhere('meeting_type', 'offline');
                }
            });
            // if ($search=='online') {
            //         return $q->where('meeting_type' , 'online');
            // } elseif ($search=='offline') {
            //         return $q->where('meeting_type' , 'offline');
            // } else {
            //     return $q;
            // }
            // return $q;
        }

        public function scopeFilterByAge($q, $search)
        {
            $minAge = substr($search,0,2);
            $maxAge = substr($search,3,5);
            $minDate = Carbon::today()->subYears($maxAge);
            $maxDate = Carbon::today()->subYears($minAge -1)->endOfDay();
            return $q->whereBetween('dob', [$minDate, $maxDate]);
        }


        public function scopeFilterByName($query, $name)
        {
            if ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            }
        }

        public function scopeFilterByMaterials($q, $search)
        {
            // return $q->whereHas('materials', function ($q) use ($search) {
            //     $q->whereIn('category_id', $search);
            // });

            return $q->whereIn('material_id', $search);
        }

        public function scopeFilterByLanguages($q, $search)
        {
            return $q->whereHas('languages', function ($q) use ($search) {
                $q->whereIn('category_id', $search);
            })
            ->orWhereIn('mother_lang_id', $search)
            ;
        }

        public function scopeFilterByGender($q, $search)
        {
            if (is_array($search) && !empty($search)) {
                return $q->whereIn('gender', $search);
            } elseif (is_string($search) && ($search === 'male' || $search === 'female')) {
                return $q->where('gender', $search);
            }

            return $q;
        }

        public function scopeFilterByCountry($q, $search)
        {
            return $q->whereIn('country_id', $search);
        }

        public function scopeFilterByMotherLanguage($q, $search)
        {
            return $q->whereIn('mother_lang_id', $search);
        }

        public function scopeFilterByLecturerType($q, $search)
        {
            if (is_array($search) && !empty($search)) {
                return $q->whereIn('belongs_to_awael', $search);
            } elseif (is_string($search) && ($search === '1' || $search === '0')) {
                return $q->where('belongs_to_awael', $search);
            }

            return $q;
        }

        public function scopeFilterByLessonPrice($q, $price_from, $price_to)
        {
            return $q->whereHas('teacherPrivateLessons', function ($q) {
                $q->activeLessons();
            })->whereBetween('hour_price', [$price_from, $price_to]);
        }

    // End Filters



    public function userRoles()
    {
        return $this->hasMany('App\Models\UserRoles', 'user_id', 'id');
    }

    public function checkRole($role)
    {
        $item =UserRoles::where([
            ['user_id',$this->id],
            ['role',$role]
        ])->count();

        return $item==1;

    }

    public function hasCoupon()
    {
        $user_id=$this->id;

        $coupon=Coupons::whereHas('allMarketers', function (Builder $query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->first();

        return $coupon!=null;


    }

    public function packages()
    {
        return $this->hasMany('App\Models\Packages', 'user_id');
    }

    public function user_packages()
    {
        return $this->hasMany(UserPackages::class, 'user_id');
    }


    public function timeTable()
    {
        return $this->hasMany('App\Models\LecturerTimeTable', 'user_id', 'id');
    }


    // user_remain_hours
    function getUserRemainHoursAttribute() {
        $packages = $this->user_packages()->paid()
        ->has('package_valid')->get();
        $user_remain_hours = 0;
        foreach ($packages as $key => $user_package) {
            $user_remain_hours += $user_package->num_hours;
            $user_remain_hours -= $this->used_hours_package($user_package->id);
        }
        return $user_remain_hours > 0 ? $user_remain_hours : 0;
    }

    // packages_total_hours
    function getPackagesTotalHoursAttribute() {
        return (int) $this->user_packages()
        ->has('package_valid')
        ->sum('num_hours');
        // SELECT DATE_ADD(created_at, INTERVAL num_months MONTH) as datee from packages;
    }

    // used_hours    from private_lessons
    function getUsedHoursAttribute() {
        return (int) $this->privateLessons->where('status' , 'acceptable')->where('time_type' , 'hour')->count()
        +
        (int) (.5  * $this->privateLessons->where('status' , 'acceptable')->where('time_type' , 'half_hour')->count())
        ;
    }

    // used_hours    from user_packages
    function used_hours_package($user_package_id = null) {
        return (int) $this->privateLessons->where('status' , 'acceptable')->where('user_package_id' , $user_package_id)->where('time_type' , 'hour')->count()
        +
        (int) (.5  * $this->privateLessons->where('status' , 'acceptable')->where('user_package_id' , $user_package_id)->where('time_type' , 'half_hour')->count())
        ;
    }

}
