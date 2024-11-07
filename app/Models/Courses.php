<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Courses extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Translatable;

    const LIVE = 'live';

    const RECORDED = 'recorded';

    const  BEING_PROCESSED='being_processed';

    const  READY='ready';

    const  ACCEPTED='accepted';

    const  UNACCEPTED='unaccepted';

   protected $fillable = ['id', 'image','user_id', 'cover_image', 'welcome_text_for_registration_image',
   'certificate_text_image','certificate_template_id','faq_image', 'video',
   'video_image', 'start_date', 'end_date','published',
   'number_of_free_lessons','age_range_id', 'lessons_follow_up',
   'language_id', 'category_id', 'age_range_id','level_id', 'type','duration','grade_level_id','grade_sub_level',
   'total_rate', 'is_active','status', 'video_type', 'total_sales', 'is_delete',
    'can_subscribe_to_session','can_subscribe_to_session_group','open_installments','material_id'];

    public $translatedAttributes = ['title', 'description', 'welcome_text_for_registration', 'certificate_text'];

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

    public function groups()
    {
        return $this->hasManyThrough(
            CourseSessionsGroup::class,
            CourseSession::class,
            'course_id',
            'id',
            'id',
            'group_id'
        );
    }
    public function scopeFilter($q, $search)
    {
        return $q->whereHas('translations', function ($q) use ($search) {
            return $q->where('title', 'like', '%' . $search . '%');
        });
    }

    public function scopeFilterByTitle($q, $search)
    {
        return $q->whereHas('translations', function ($q) use ($search) {
            return $q->where('title', 'like', '%' . $search . '%');
        });
    }

    public function scopeFilterByPrice($q, $search)
    {
        if ($search == 'free') {
            $q = $q->WhereDoesntHave('priceDetails')
                ->orwhereHas('priceDetails', function ($q) use ($search) {
                    return $q->whereNull('price');;
                });
        } elseif ($search == 'paid') {
            $q = $q->whereHas('priceDetails', function ($q) use ($search) {
                return $q->whereNotNull('price');;
            });
        }
        return $q;
    }

    public function scopeFilterByPriceRange($q, $from, $to)
    {
        if ($from != '') {
            $q = $q->whereHas('priceDetails', function ($q) use ($from) {
                return $q->where('price', '>=', $from);
            });
        }
        if ($to != '') {
            $q = $q->whereHas('priceDetails', function ($q) use ($to) {
                return $q->where('price', '<=', $to);
            });
        }
        return $q;
    }

    public function scopeFilterByType($q, $search)
    {
        return $q->where('type', $search);
    }

    public function scopeFilterByStatus($q, $search)
    {
        return $q->whereIn('status', $search);
    }


    public function scopeFilterByCategories($q, $search)
    {
        return $q->whereIn('material_id', $search);
    //   return $q->where('category_id', $search);
    }

    public function scopeFilterByLanguages($q, $search)
    {
        return $q->whereIn('language_id', $search);
    }

    public function scopeFilterByGradeSubLevel($q, $search)
    {
        return $q->where('grade_sub_level', $search);
    }
    public function scopeFilterByLevels($q, $search)
    {
        return $q->whereIn('level_id', $search);
    }

    public function scopeFilterByAgeRanges($q, $search)
    {
        return $q->whereIn('age_range_id', $search);
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }

    public function scopeAccepted($q)
    {
        return $q->where('status', 'accepted');
    }

    // subscribed()
    public function scopeSubscribed($q)
    {
        return $q->withTrashed()
        ->when( checkUser('student') , function($course){
            $course->where('is_active', 1)->whereNull('deleted_at')
            ->orWhere(function($course){
                $course->WhereHas('students' , function($course_student){
                    $course_student->where('user_id' , auth('web')->id() )->where('is_paid' , 1 );
                });
            });
        })
        ->when( !checkUser('student') , function($course){
            $course->where('is_active', 1)->whereNull('deleted_at');
        })
        ;
    }

    public function scopeDeleted($q)
    {
        return $q->where('deleted_at', '==', null);
    }

    public function language()
    {
        return $this->hasOne('App\Models\Category', 'value', 'language_id')->where('parent', 'course_languages');
    }

    /**
     * Get the user that owns the Courses
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function certificateTemplate()
    {
        return $this->belongsTo(CertificateTemplates::class, 'certificate_template_id','id');
    }

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'value', 'category_id')->where('parent', 'course_categories');
    }

    public function material()
    {
        return $this->hasOne('App\Models\Category', 'id', 'material_id')->where('parent', 'joining_course');
    }

    public function level()
    {
        return $this->hasOne('App\Models\Category', 'value', 'level_id')->where('parent', 'course_levels');
    }
    public function grade_level()
    {
        return $this->hasOne('App\Models\Category', 'value', 'grade_level_id')->where('parent', 'grade_levels');
    }

    public function grade_sub_level()
    {
        return $this->hasOne('App\Models\Category', 'value', 'grade_sub_level_id');
    }

    public function age_range()
    {
        return $this->hasOne('App\Models\Category', 'value', 'age_range_id')->where('parent', 'age_categories');
    }

    public function priceDetails()
    {
        return $this->hasOne('App\Models\CoursePriceDetails', 'course_id', 'id');
    }

    public function lecturers()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function lecturer()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function faqs()
    {
        return $this->hasMany('App\Models\CourseFaqs', 'course_id', 'id');
    }

    public function contentDetails()
    {

       return $this->hasMany('App\Models\CourseContentDetails', 'course_id', 'id');
    }

    public function whatWillYouLearn()
    {
        return $this->contentDetails()->where('type', 'what_will_you_learn');
    }

    public function forWhomThisCourse()
    {
        return $this->contentDetails()->where('type', 'for_whom_this_course');
    }

    public function content()
    {
        return $this->contentDetails()->where('type', 'content');
    }

    public function requirements()
    {

        return $this->hasMany('App\Models\CourseRequirements', 'course_id', 'id');
    }

    public function evaluation()
    {
        return $this->hasMany(AddCourseRequests::class, 'courses_id', 'id')->latest();
    }

    public function sections()
    {

        return $this->hasMany('App\Models\CourseSections', 'course_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(CourseCurriculum::class, 'course_id', 'id')->orderBy('order', 'asc');
    }

    public function courseCurriculums(): HasMany
    {
        return $this->hasMany(CourseCurriculum::class);
    }

    public function items_active()
    {
        return $this->hasMany(CourseCurriculum::class, 'course_id', 'id')->where('is_active' , 1)->orderBy('order', 'asc');
    }


    public function sectionItems()
    {
        return $this->hasManyThrough(
            CourseSectionItems::class,  // The target model
            CourseSections::class,      // The intermediate model
            'course_id',                // Foreign key on the intermediate model
            'course_sections_id',       // Foreign key on the target model
            'id',                       // Local key on the source model (Course)
        )->orderBy('order', 'asc');
    }

    public function getTotalItemsCount()
    {
        $items = CourseCurriculum::active()->where('course_id', $this->id)->where('itemable_type', '!=', 'section')->count();
        $section_items = CourseSectionItems::active()->where('course_id', $this->id)->count();

        return $items + $section_items;
    }

    public function gettotalCompletedItemsCount()
    {

        $completed_items = CourseCurriculum::active()->where('course_id', $this->id)->where('itemable_type', '!=', 'section')->allCompletedItems()->count();
        $completed_section_items = CourseSectionItems::active()->where('course_id', $this->id)->allCompletedItems()->count();

        return $completed_items + $completed_section_items;
    }

    public function updateProgress()
    {
        $total_items = $this->getTotalItemsCount();

        if ($total_items === 0)
            return 0;

        $total_completed_items = $this->gettotalCompletedItemsCount();

        $progress = round(($total_completed_items / $total_items) * 100, 2);

        ($progress == 100) ? $is_end = 1 : $is_end = 0;

        $user_course = UserCourse::where(['course_id' => $this->id, 'user_id' => auth()->id()])->first();
        $user_course->update(['progress' => $progress, 'is_end' => $is_end]);

        return true;
    }

    // public function getProgress()
    // {
    //     $totalItems = $this->items->count();

    //     if ($totalItems === 0) {
    //         return 0;
    //     }

    //     $completedItems = $this->completedItems->count();

    //     $progress = round(($completedItems / $totalItems) * 100, 2);

    //     return $progress;
    // }

    public function suggestedDates()
    {

        return $this->hasMany('App\Models\CourseSuggestedDates', 'course_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Ratings', 'sourse_id', 'id')->where(
            [
                ['is_active', 1],
                ['sourse_type', Ratings::COURSE]
            ]
        );
    }

    public function getRate()
    {
        $count_rate = count($this->reviews);
        $total_rate = $this->hasMany('App\Models\Ratings', 'sourse_id', 'id')->sum('rate');

        return [
            'count_rate' => $count_rate,
            'total_rate' => $total_rate,
        ];
    }

    public function getRating()
    {
        $ratings_sum = $this->reviews->sum('rate');

        $ratings_count = $this->getRatingCount();

        if ($ratings_count == 0) {
            return 0;
        }

        return round(fdiv($ratings_sum, $ratings_count));
    }

    public function getRatingCount()
    {
        return count($this->reviews);
    }

    public function students()
    {
        return $this->hasMany('App\Models\UserCourse', 'course_id', 'id');
    }


    public function graduates()
    {
        return $this->hasMany('App\Models\UserCourse', 'course_id', 'id')->where('is_end', 1);
    }

    public function isSubscriber($guard = 'web')
    {
        if (checkUser('student',$guard)) {
            $item = UserCourse::select('id', 'user_id', 'course_id')
                ->where([['user_id', getUser($guard)->id],
                    ['course_id', $this->id]
                ])
                ->where('is_paid' , 1)
                ->first();
            if ($item) {
                return true;
            }
        }
        return false;
    }

    public function getDurationInMonths()
    {
        $duration = '';
        if ($this->duration == 1) {
            $duration = __('month');
        } elseif ($this->duration == 2) {
            $duration = __('two_months');
        } elseif ($this->duration > 2) {
            $duration = $this->duration . ' ' . __('months');
        }

        return $duration;
    }

    public function getDurationInDays()
    {
        if (!empty($this->start_date) && !empty($this->end_date))
        {
            $start_date = Carbon::parse($this->start_date);
            $end_date = Carbon::parse($this->end_date);
    
            return $start_date->diffInDays($end_date);
        }

        return 0;
    }

    public function cost()
    {
        $price_details = $this->priceDetails()->first();
        $user = auth()->user();

        $price  =  $price_details->discount_price ?? $price_details->price;
        if (!$price) {
            return 0;
        } else {
            if($user && $user->country) {
                $price = ceil($user->country->currency_exchange_rate * $price);
            } else {
                $price = $price;
            }
            return $price;
        }
    }

    public function getPriceForPayment()
    {
        $price_details = $this->priceDetails()->first();
        $price  =  $price_details->discount_price ?? $price_details->price;

        return $price;
    }

    public function getPrice()
    {
        $price_details = $this->priceDetails()->first();
        $user = auth()->user();

        $price  =  $price_details->discount_price ?? $price_details->price;
        if ($price == '') {
            return __('price_types.free');
        } else {
            if($user && $user->country) {
                $price = ceil($user->country->currency_exchange_rate * $price) . " ".$user->country->currency_name;
            } else {
                $price = $price . ' ' . __('currency') . ' ';
            }
            return $price;
        }
    }

    public function getPriceDisc()
    {
        $price_details = $this->priceDetails()->first();
        $user = auth()->user();

        $discount_price = $price_details->discount_price;
        $price          = $price_details->price;
        if (!$price && !$discount_price ) {
            return __('price_types.free');
        } else
        {
            $price = number_format($price,2) . ' ' . __('currency') . ' ';
            if($discount_price){
                $price           = "<del>" . $price . "</del> &nbsp;";
                $discount_price  = number_format($discount_price,2) . ' ' . __('currency') . ' ';
                $price          .=  $discount_price;
            }
            return $price;
        }
    }

    public function getTotalSales() // lecturer total sales
    {
        $user = auth()->user();

        if($user && $user->country) {
            $total_sales = ceil($user->country->currency_exchange_rate*$this->total_sales) . " ".$user->country->currency_name;
        } else {
            $total_sales = $this->total_sales. ' ' . __('currency') . ' ';
        }
        return $total_sales;
    }

    public function deleteWithAssociations()
    {
        CourseQuizzes::where('course_id', $this->id)->delete();

        CourseLessons::where('course_id', $this->id)->delete();

        CourseAssignments::where('course_id', $this->id)->delete();

        $this->items()->delete();

        $this->sectionItems()->delete();

        $this->delete();
    }
    public function sessions()
    {
        return $this->hasMany(CourseSession::class,'course_id');
    }

    public function transaction(): MorphOne
    {
        return $this->morphOne(Transactios::class, 'transactionable')->orderBy('created_at' , 'desc');
    }


    // last_item
    function getLastItemAttribute() {
        return CourseCurriculum::active()->where('course_id', $this->id)->order('desc')->first();
    }


}
