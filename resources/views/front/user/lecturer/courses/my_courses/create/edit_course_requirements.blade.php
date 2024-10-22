
@extends('front.user.lecturer.layout.index')

@push('front_css')
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-datetimepicker.min.css') }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
    <style>
         .multipleChosen, .multipleSelect2{
            width: 300px;
          }
    </style>
@endpush

@section('content')

    @php
        $item = isset($item) ? $item : null;

        isset($item) ? $title_page = @$item->title : $title_page = __('add');

        $breadcrumb_links = [
            [
                'title' => __('home'),
                'link' => route('user.home.index'),
            ],
            [
                'title' => __('courses'),
                'link' => route('user.lecturer.my_courses.index'),
            ],
            [
                'title' => $title_page,
                'link' => '#',
            ],
        ];
    @endphp
    @section('title', $title_page)

    <section class="section wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            @include('front.user.lecturer.layout.includes.course_breadcrumb', ['breadcrumb_links' => $breadcrumb_links,])

            <form id="courseForm" method="{{ isset($item) ? 'POST' : 'POST' }}" to="{{ url()->current() }}"
                url="{{ url()->current() }}" enctype="multipart/form-data" class="w-100">
                @csrf

                <div class="container">
                    <div class="row">
                        <div class="card card-custom gutter-b example example-compact">
                            <div class="card-body">
                                <div class="row">
                                    <div id="kt_repeater_1" class="w-100">
                                        <div class=" row">
                                            @include('front.user.lecturer.courses.my_courses.create.partials.toolbar')
                                            <div class="col-lg-12">
                                                @php
                                                    $content_details = $item->requirements;
                                                @endphp
                                                @if ($content_details)
                                                    <input type="hidden" id="needToolbarConfirm" value="false">
                                                @else
                                                    <input type="hidden" id="needToolbarConfirm" value="true">
                                                @endif

                                                @include('front.user.lecturer.courses.my_courses.create.partials.course_requirement_form')

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('front.user.lecturer.courses.new_course.components.save_button')
            </form>
        </div>
    </section>

    @include('front.user.lecturer.courses.my_courses.create.components.request_review_modal')



@push('front_js')
    <script src="{{ asset('assets/front/js/post.js') }}"></script>
    <script src="{{ asset('assets/panel/js/pages/crud/forms/widgets/repeater.js') }}"></script>
    <script src="{{ asset('assets/panel/js/pages/crud/forms/widgets/form-repeater.js') }}"></script>
    <script src="{{ asset('assets/panel/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>
    <script src="{{ asset('assets/panel/js/pages/crud/forms/editors/tinymce.js') }}?v=1"></script>

    <script>
        $('.add-faq').click(function() {
            tinymce.init({
                selector: '.tinymce'
            });
        });
    </script>

@endpush

@endsection
