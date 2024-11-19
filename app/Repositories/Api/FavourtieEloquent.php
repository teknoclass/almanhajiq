<?php

namespace App\Repositories\Api;

use App\Http\Resources\ApiCourseCollection;
use App\Http\Resources\ApiCourseFilterCollection;
use App\Models\Favourite;
use App\Models\UserCourse;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\Courses\CoursesResource;
use App\Http\Resources\Favourite\BlogResource;
use App\Http\Resources\Favourite\CourseResource;
use App\Http\Resources\Favourite\LecturerResource;
use App\Http\Resources\PostsCollection;
use App\Http\Resources\TeacherCollection;
use App\Repositories\Front\User\HelperEloquent;

class FavourtieEloquent extends HelperEloquent{

    function toggle($request)
    {
       $favorite = Favourite::updateOrCreate(
        ['source_id' => $request->get('source_id') , 'source_type' => $request->get('source_type') , 'user_id' => auth('api')->id()],
        ['status' => $request->get('status')]
       );
    }


    function get($request,$is_web = true)
    {
        $user = $this->getUser($is_web);
        if($is_web)$user_type = 'web';
        else $user_type = 'api';
        $type = $request->get('type');
        if($type != 'course' && $type != 'lecturer' && $type != 'blog')
        {
            $data['status'] = false;
            $data['message'] = __('message.not_valid_type');
            $data['data'] = [];
            return $data;
        }
        switch($type){
            case 'course' :
                $favourite = Favourite::where('user_id' , $user->id)->where('source_type',$type)->where('status',1)->with([
                    'course' => function ($query) use ($user_type){
                        $query->active()->accepted()
                            ->select(
                                'id',
                                'user_id',
                                'image',
                                'start_date',
                                'duration',
                                'type',
                                'category_id',
                                'is_active',
                                'level_id'
                            )
                            ->with('translations:courses_id,title,locale,description')
                            ->with([
                                'category' => function ($query) {
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
                            ->addSelect([
                                'progress' => UserCourse::select('progress')
                                    ->whereColumn('course_id', 'courses.id')
                                    ->where('user_id', auth($user_type)->id())->limit(1)
                            ])
                            ->withCount('items')
                            ->with([
                                'lecturers' => function ($query) {
                                    $query->select('id', 'name', 'image');
                                }
                            ])
                            ->orderBy('id', 'desc')
                            ->with([
                                'level' => function ($query) {
                                    $query->select('id', 'value', 'parent')
                                        ->with('translations:category_id,name,locale');
                                }
                            ])
                            ->with([
                                'reviews','priceDetails'
                            ]);
                        }
                    ])->paginate(10);
                    $favourite = [
                        'data' => CourseResource::collection($favourite),
                        'pagination' => new PaginationResource($favourite)
                    ];

                break;
            case 'lecturer' :

                $favourite = Favourite::where('user_id' , $user->id)->where('source_type',$type)->where('status',1)->with([
                    'lecturer' => function ($query){
                            $query->select(
                                'id',
                                'name',
                                'mobile',
                                'image',
                                'gender',
                                'city',
                                'dob',
                                'belongs_to_awael',
                                'country_id',
                                'mother_lang_id'
                            )->where('role', 'lecturer')
                            ->with([
                                'motherLang' => function ($query) {
                                    $query->select('id', 'value', 'parent')
                                        ->with('translations:category_id,name,locale');
                                }
                            ])
                            ->orderBy('id', 'desc');
                        }
                    ])->paginate(10);
                    $favourite = [
                        'data' => LecturerResource::collection($favourite),
                        'pagination' => new PaginationResource($favourite)
                    ];

                break;
            case 'blog' :
                $favourite = Favourite::where('user_id' , $user->id)->where('source_type',$type)->where('status',1)->with([
                    'blog' => function ($query){
                        $query->latest()
                        ->select('id', 'image','user_id','created_at','category_id')
                        ->with(['translations:posts_id,title,locale,text', 'user:id,name,image'])
                        ->with([
                            'category' => function ($query) {
                                $query->select('id', 'value', 'parent')
                                    ->with('translations:category_id,name,locale');
                            }
                        ]);
                        }
                    ])->paginate(10);
                    $favourite = [
                        'data' => BlogResource::collection($favourite),
                        'pagination' => new PaginationResource($favourite)
                    ];

                break;
        }
        $data['status'] = true;
        $data['message'] = __('message.operation_accomplished_successfully');
        $data['data'] = $favourite;
        return $data;
    }




}
