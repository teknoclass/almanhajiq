<?php

namespace App\Models;

use App\Strategies\ItemStrategyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;

class CourseSectionItems extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'course_sections_id', 'itemable_type', 'itemable_id', 'order'];


    public function section(): BelongsTo
    {
        return $this->belongsTo(CourseSections::class,'course_sections_id');
    }
    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id', 'id');
    }

    public function itemable(): MorphTo
    {
        return $this->morphTo();
    }
    public function isCompleted(): bool
    {
        $strategy = ItemStrategyFactory::create($this->itemable_type,null);
        return $strategy->isCompleted();
    }

    public function scopeActive($query)
    {
        return $query->whereHasMorph('itemable', [
            CourseLessons::class,
            CourseQuizzes::class,
            CourseAssignments::class,
            CourseSections::class
        ], function ($query) {
            $query->active();
        });
    }

    public function scopeCompletedItems($query, array $itemTypes)
    {
        return $query->where(function ($query) use ($itemTypes) {
            $query->when(in_array('lesson', $itemTypes), function ($query) {
                $query->orWhere(function ($query) {
                    $query->where('itemable_type', CourseLessons::class)
                          ->whereHas('lessonStatus', function ($query) {
                              $query->where('user_id', auth()->id());
                          });
                });
            });

            $query->when(in_array('quiz', $itemTypes), function ($query) {
                $query->orWhere(function ($query) {
                    $query->where('itemable_type', CourseQuizzes::class)
                          ->whereHas('quizResults', function ($query) {
                              $query->where('user_id', auth()->id())
                                    ->where('status', '!=', CourseQuizzesResults::$waiting);
                          });
                });
            });

            $query->when(in_array('assignment', $itemTypes), function ($query) {
                $query->orWhere(function ($query) {
                    $query->where('itemable_type', CourseAssignments::class)
                          ->whereHas('assignmentResults', function ($query) {
                              $query->where('student_id', auth()->id())
                                    ->where('status', '!=', CourseAssignmentResults::$notSubmitted);
                          });
                });
            });
        });
    }
    public function scopeAllCompletedItems($query)
    {
        return $query->where(function ($query) {
            $query->completedItems(['lesson', 'quiz', 'assignment'])
                  ->orWhere(function ($query) {
                      $query->sectionHasCompletedItem();
                  });
        });
    }
    public function scopeSectionHasCompletedItem($query)
    {
        return $query->where('itemable_type', CourseSections::class)
                     ->whereHas('section.items', function ($query) {
                         $query->completedItems(['lesson', 'quiz', 'assignment']);
                     });
    }

    public function scopeActiveStatusBasedOnUser($query)
    {
        if (Auth::guard('web')->check() && checkUser('student')) {
            return $query->active();
        }
    }
    public function lessonStatus()
    {
        return $this->hasOne(CourseLessonsLearning::class, 'lesson_id', 'itemable_id')->where('lesson_type', 'normal');
    }

    public function quizResults()
    {
        return $this->hasMany(CourseQuizzesResults::class, 'quiz_id', 'itemable_id')->latest();
    }

    public function assignmentResults()
    {
        return $this->hasMany(CourseAssignmentResults::class, 'assignment_id', 'itemable_id')->latest();
    }
    public function is_completed()
    {
        $type = config('constants.item_types.'.$this->itemable_type);
        $strategy = ItemStrategyFactory::create($this->itemable_id, $type);
        return $strategy->isCompleted();
    }

    public function canAccess()
    {
        $previousItems = $this->getPreviousItems();

        foreach ($previousItems as $item) {
            if (!$item->is_completed()) {
                return false;
            }
        }

        return true;
    }

    protected function getPreviousItems()
    {
        return $this->where('order', '<', $this->order)
                    ->where('course_id', $this->course_id)
                    ->where('id', $this->id)
                    ->active()
                    ->get();
    }



    //NOTE:this function is made to not get error in recorded courses that is dont have installment system
    function isSubInInstallment()
    {
        return 0;
    }

    function canAccessApi(){
        if($this->course->lessons_follow_up == 0)return 1;

        $course = $this->course;
        $items = $course->items_active;
        $array = array();

        foreach($items as $item){
            if(config("constants.item_model_types.".$item['itemable_type']) == "section"){
                foreach($item->itemable->items as $item2){

                    $payload = [
                        'type' => config("constants.item_model_types.$item2->itemable_type"),
                        'id' => $item2->itemable_id,
                        'is_completed' => $item2->is_completed()
                    ];

                    $array[] = $payload;
                }

            }else{
                $payload = [
                    'type' => config("constants.item_model_types.$item->itemable_type"),
                    'id' => $item->itemable_id,
                    'is_completed' => $item->is_completed()
                ];
                $array[] = $payload;
            }


        }

        $index = -1;
        for($i = 0 ; $i < sizeof($array) ; $i+=1){

            if($array[$i]['id'] == $this->itemable_id){
                $index = $i;
                break;
            }
        }
        if($index == 0)return 1;
        if($index == -1)return 0;
        if($array[$index-1]['is_completed'] == 1)return 1;
        else return 0;

    }

}
