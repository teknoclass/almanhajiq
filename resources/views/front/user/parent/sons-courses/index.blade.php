@extends('front.layouts.index' , ['is_active'=>'customers','sub_title'=>__('customers'), ])
@section('content')

<section class="section wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
          <div class="row mb-3">
            <div class="col-12">
              <div class="d-flex align-items-center justify-content-between">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="{{route('user.home.index')}}">
                    {{__('home')}}
                  </a></li>
                  <li class="breadcrumb-item active">
                  {{__('sons')}}
                  </li>
                  <li class="breadcrumb-item active">
                  {{ @$son->son->name }}
                  </li>
                  <li class="breadcrumb-item active">
                  {{__('courses_details')}}
                  </li>
                </ol>
              </div>



          <div class="row">
            <div class="col-12">
             <div class="all-data">
          
             <div class="table-container">
                <table class="table table-cart mb-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="">{{ __('title') }}</th>
                         
                            <th>
                                {{__('material')}}
                            </th>

                            <th>
                                {{__('grade_level')}}
                            </th>
                            <th>
                                {{__('grade_sub_level_id')}}
                            </th>
                            <th>{{ __('type') }}</th>
                            <th>{{ __('price') }}</th>
                            <th>{{ __('details') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($courses as $k=>$course)
                            <tr>
                                <th>{{++$k}}</th>
                                <td>
                                    {{ @$course->title }}
                                </td>
                                <td>
                                    {{ @$course->material->name ?? '' }}
                                </td>
                                <td>
                                {{@App\Models\Category::find(@$course->grade_level_id)->name ?? ""}} 
                                </td>
                                <td>
                                {{@App\Models\Category::find(@$course->grade_sub_level)->name ?? ""}} 
                                </td>
                                <td> {{ __(@$course->type) }}</td>
                                <td> {!! @$course->getPriceDisc() !!}</td>
                                <td>
                                <a class="btn btn-primary  btn-sm" href="{{route('user.parent.sons.course.details',['course_id' => $course->id,'son_id' => $son->son_id])}}">   {{__('details')}}</a>
                                </td>
                            </tr>
                            @empty
                        <tr>
                            <td colspan="8" class="text-center">{{__('no_data')}}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

             
             </div>
            </div>
          </div>
        </div>
      </section>


@endsection
