<?php

namespace App\Repositories\Front;

use App\Models\Category;
use App\Models\Coupons;
use App\Models\CourseCurriculum;
use App\Models\CoursePriceDetails;
use App\Models\Courses;
use App\Models\User;
use App\Models\UserCourse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class CoursesEloquent
{
    public function index($request)
    {
        $data = $this->getData($request);

        $data['categories']  = Category::getCategoriesByParent('course_categories')->orderByDesc('created_at')->get();

        $data['languages']  = Category::getCategoriesByParent('course_languages')->orderByDesc('created_at')->get();

        $data['levels']  = Category::getCategoriesByParent('course_levels')->orderByDesc('created_at')->get();

        $data['age_categories']  = Category::getCategoriesByParent('age_categories')->orderByDesc('created_at')->get();
        $data['grade_levels']      = Category::where('key', 'grade_levels')->get();
        $data['grade_sub_level']      = Category::where('parent', 'grade_levels')->get();

        return $data;
    }

    public function getData($request, $count_itmes = 8)
    {
        $data['courses'] = Courses::active()->accepted()->subscribed()
            ->select(
                'id',
                'image',
                'start_date',
                'duration',
                'type',
                'category_id',
                'is_active',
                'user_id',
            )
            ->with('translations:courses_id,title,locale,description')
            ->with([
                'category' => function ($query) {
                    $query->select('id', 'value', 'parent')
                        ->with('translations:category_id,name,locale');
                }
            ])
            ->addSelect([
                'progress' => UserCourse::select('progress')
                    ->whereColumn('course_id', 'courses.id')
                    ->where('user_id', auth()->id())->limit(1)
            ])
            ->withCount('items')
            ->orderBy('id', 'desc');

        $title = $request->get('title');
        if ($title != '') {
            $data['courses'] = $data['courses']->filterByTitle($title);
        }

        $price_type = $request->get('price_type');
        if ($price_type != '') {
            $data['courses'] = $data['courses']->filterByPrice($price_type);
        }

        if ($price_type == 'paid') {
            $price_from = $request->get('price_from');
            $price_to = $request->get('price_to');
            if ($price_from != '' || $price_to != '') {
                $data['courses'] = $data['courses']->filterByPriceRange($price_from, $price_to);
            }
        }

        $course_type = $request->get('course_type');
        if ($course_type != '') {
            $data['courses'] = $data['courses']->filterByType($course_type);
        }

        try {
            $category_ids = $request->get('category_ids');
            if ($category_ids) {
                $data['courses'] = $data['courses']->filterByCategories(json_decode($category_ids));
            }
        } catch (\Exception $e) {
        }

        try {
            $language_ids = $request->get('language_ids');
            if ($language_ids) {
                $data['courses'] = $data['courses']->filterByLanguages(json_decode($language_ids));
            }
        } catch (\Exception $e) {
        }

        try {
            $level_ids = $request->get('level_ids');
            if ($level_ids) {
                $data['courses'] = $data['courses']->filterByLevels(json_decode($level_ids));
            }
        } catch (\Exception $e) {
        }

        try {

            $grade_sub_level = $request->get('grade_sub_level');

            if ($grade_sub_level) {

                $data['courses'] = $data['courses']->filterByGradeSubLevel(json_decode($grade_sub_level));
            }
        } catch (\Exception $e) {
        }

        try {
            $age_range_ids = $request->get('age_range_ids');
            if ($age_range_ids) {
                $data['courses'] = $data['courses']->filterByAgeRanges(json_decode($age_range_ids));
            }
        } catch (\Exception $e) {
        }


        try {
            $id = $request->get('id');
            if ($id && $id != "") {
                $data['courses'] = $data['courses']->where('id',$id);
            }
        } catch (\Exception $e) {
        }

        try {
            $grade_level_id = $request->get('grade_level_id');
            if ($grade_level_id && $grade_level_id != "") {
                $data['courses'] = $data['courses']->where('grade_level_id',$grade_level_id);
            }
        } catch (\Exception $e) {
        }

        try {
            $grade_sub_level = $request->get('grade_sub_level');
            if ($grade_sub_level&& $grade_sub_level != "") {
                $data['courses'] = $data['courses']->where('grade_sub_level',$grade_sub_level);
            }
        } catch (\Exception $e) {
        }

        $data['lecturers'] = $data['courses'] ->with([
            'lecturers.lecturerSetting' => function ($query) {
                $query->select('id', 'user_id', 'video_thumbnail', 'video_type', 'video', 'exp_years', 'twitter', 'facebook', 'instagram', 'youtube')
                      ->with('translations:lecturer_setting_id,abstract,description,position,locale');
            }
        ])->paginate(9);

        $data['courses'] = $data['courses']->paginate(9);


        return $data;
    }

    public function single($id)
    {
        $course = Courses::active()->accepted()
            ->select(
                'id',
                'user_id',
                'image',
                'cover_image',
                'welcome_text_for_registration_image',
                'certificate_text_image',
                'faq_image',
                'video',
                'video_type',
                'video_image',
                'start_date',
                'type',
                'category_id',
                'level_id',
                'age_range_id',
                'is_active',
                'language_id',
                'start_date',
                'duration',
                'can_subscribe_to_session_group',
                'can_subscribe_to_session',
                'published',
                'open_installments'
            )
            ->with('translations:courses_id,title,locale,description,welcome_text_for_registration,certificate_text')
            ->with([
                'category' => function ($query) {
                    $query->select('id', 'value', 'parent')
                        ->with('translations:category_id,name,locale');
                }
            ])
            ->with([
                'language' => function ($query) {
                    $query->select('id', 'value', 'parent')
                        ->with('translations:category_id,name,locale');
                }
            ])
            ->with([
                'level' => function ($query) {
                    $query->select('id', 'value', 'parent')
                        ->with('translations:category_id,name,locale');
                }
            ])
            ->with([
                'age_range' => function ($query) {
                    $query->select('id', 'value', 'parent')
                        ->with('translations:category_id,name,locale');
                }
            ])
            ->with([
                'faqs' => function ($query) {
                    $query->select('id', 'course_id', 'faq_id', 'is_active', 'order')->active()
                        ->with([
                            'faq' => function ($query) {
                                $query->select('id', 'order')
                                    ->with('translations:faqs_id,title,text,locale');
                            }
                        ]);
                }
            ])
            ->with([
                'reviews' => function ($query) {
                    $query->select(
                        'id',
                        'sourse_type',
                        'sourse_id',
                        'user_id',
                        'rate',
                        'comment_text',
                        'is_active',
                    )->active()
                        ->with([
                            'user' => function ($query) {
                                $query->select('id', 'name', 'image');
                            }
                        ]);
                }
            ])
            ->with([
                'whatWillYouLearn' => function ($query) {
                    $query->select('id', 'course_id', 'image', 'type')
                        ->with('translations:course_content_details_id,title,description,locale');
                }
            ])
            ->with([
                'forWhomThisCourse' => function ($query) {
                    $query->select('id', 'course_id', 'image', 'type')
                        ->with('translations:course_content_details_id,title,description,locale');
                }
            ])
            ->with([
                'content' => function ($query) {
                    $query->select('id', 'course_id', 'image', 'type')
                        ->with('translations:course_content_details_id,title,description,locale');
                }
            ])
            ->with([
                'priceDetails' => function ($query) {
                    $query->select('id', 'course_id', 'price');
                }
            ])
            ->with([
                'lecturers' => function ($query) {
                    $query->select('id', 'name', 'image')
                        ->with([
                            'lecturerSetting' => function ($query) {
                                $query->select('id', 'user_id')
                                ->with('translations:lecturer_setting_id,position,abstract,locale');
                            }
                        ]);
                }
            ])
            ->addSelect([
                'progress' => UserCourse::select('progress')
                    ->whereColumn('course_id', 'courses.id')
                    ->where('user_id', auth()->id())->limit(1),

                'is_end' => UserCourse::select('is_end')
                    ->whereColumn('course_id', 'courses.id')
                    ->where('user_id', auth()->id())->limit(1),

                'is_rating' => UserCourse::select('is_rating')
                    ->whereColumn('course_id', 'courses.id')
                    ->where('user_id', auth()->id())->limit(1),
            ])
            ->withCount('items')
            ->withCount('students')
            ->where('id', $id)->first();
        $data['course'] = $course;
            // dd($data['course']);

        if (!$data['course']) abort(404);

        $data['courses'] = Courses::active()->accepted()
            ->where('id', '!=', $id)
            ->select(
                'id',
                'image',
                'start_date',
                'duration',
                'type',
                'category_id',
                'is_active',
            )
            ->with('translations:courses_id,title,locale,description')
            ->with([
                'category' => function ($query) {
                    $query->select('id', 'value', 'parent')
                        ->with('translations:category_id,name,locale');
                }
            ])
            ->addSelect([
                'progress' => UserCourse::select('progress')
                    ->whereColumn('course_id', 'courses.id')
                    ->where('user_id', auth()->id())->limit(1)
            ])
            ->withCount('items')
            ->orderBy('id', 'desc')->take(4)->get();

        $data['live_sessions'] = $course->sessions()
                                 ->whereNotNull('group_id') // Ensure that the group_id is not null
                                 ->with('group') // Eager load the group associated with each session
                                 ->get();
        $data['curriculum_items'] = CourseCurriculum::active()->where('course_id', $id)
            ->with('section.items', function ($query) {
                $query->with('itemable')->active();
            })->order('asc')->get();

        if (auth()->user() && auth()->user()->role == User::MARKETER) {
            $data['coupon']=Coupons::whereHas('allMarketers', function (Builder $query) {
                $query->where('user_id', auth()->id());
            })->first()->code ?? '';
        }
        $data['live_lessons_groups'] = Courses::where('user_id',auth()->id())
                                              ->where('type', 'live')
                                              ->whereHas('groups', function ($query) {
                                                  $query->whereHas('sessions'); // Ensure the group has sessions
                                              })
                                              ->with(['groups' => function ($query) {
                                                  $query->distinct()->with(['sessions' => function ($sessionQuery) {
                                                      $sessionQuery->distinct()->whereNotNull('group_id'); // Ensure only sessions with a group_id
                                                  }]);
                                              }])
                                              ->get();

        return $data;
    }

    public function getPrice($id)
    {
        $course_price_details = CoursePriceDetails::where('course_id', $id)->select('course_id', 'price')->first();

        return $course_price_details->price;
    }
}
