@extends('front.user.lecturer.layout.index' )

@section('content')

@push('front_css')
<link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-datetimepicker.min.css') }}"/>
@endpush

@php
$breadcrumb_links=[
    [
        'title'=>'الدورات',
       // 'link'=> route('user.lecturer.my_courses.index'),
    ],
    [
        'title'=>'إنشاء دورة جديدة',
        'link'=>'#',
    ],
];
@endphp
<section class="section wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <!--begin::breadcrumb-->
        @include('front.user.lecturer.layout.includes.breadcrumb', ['breadcrumb_links'=>$breadcrumb_links,])
        <!--end::breadcrumb-->

        <!--begin::Content-->
        <div class="row gx-xxl-8 mb-4">
            <div class="bg-white p-4 rounded-4">

                @php
                    $tabs=[
                        [
                            'title'=>'اعدادات الدورة',
                            'key'=>'settings',
                        ],
                        [
                            'title'=>'المنهج الدراسي',
                            'key'=>'curriculum',
                        ],
                        [
                            'title'=>'المتطلبات',
                            'key'=>'requirements',
                        ],
                        [
                            'title'=>'النتائج',
                            'key'=>'results',
                        ],
                        [
                            'title'=>'السعر',
                            'key'=>'pricing',
                        ],
                        [
                            'title'=>'الأسئلة الشائعة',
                            'key'=>'faqs',
                        ],
                        [
                            'title'=>'إنهاء',
                            'key'=>'finish',
                        ],
                    ];
                @endphp
                <div class="row mb-4">
                    <div class="col-12">
                        <ul class=" nav nav-pills mb-3 nav-pills-circulum">
                            @foreach ($tabs as $tab)
                            <li class="nav-item">
                                <a href="{{ route('user.lecturer.course.create', $tab['key']) }}" class="nav-link {{ $tab['key'] == @$active_tab ? 'active' : ' ' }}" >{{ $tab['title'] }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @include( 'front.user.lecturer.courses.new_course.partials.' . @$active_tab , ['key' => @$active_tab  ] )
                    </div>
                </div>
            </div>
        </div>
        <!--end::Content-->
    </div>
</section>

@push('front_js')
    @include('front.user.lecturer.courses.new_course.partials.scripts')
    <script src="{{ asset('assets/front/js/post.js') }}"></script>
    <script>
        $(document).on('click', '.action_btn', function (e) {
            e.preventDefault();
            var section = $(this).data('section');
            var action  = $(this).data('action')
            $('#'+action+'_'+section).css('display' , 'block');
            $('#'+action+'_'+section).siblings().hide();
        });

        $(document).ready(function() {
            $('.file_type').click(function() {
                var action = $(this).data('value');
               $("#file_type").val(action);
            });

            $('.video_type').click(function() {
                var action = $(this).data('value');
               $("#video_type").val(action);
            });

            $('.question_type').click(function() {
                var action = $(this).data('value');
               $("#question_type").val(action);
            });

            $(".input-file-image-1").on('change', function () {
                var $this = $(this)
                    if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    var fileName = this.files[0].name;
                    reader.onload = function (e) {
                        $($this).closest('.input-image-preview').addClass('uploaded')
                        $($this).closest('.input-image-preview').find('.img-show').text(fileName).fadeIn();
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            $(".input-file-image-1").on('change', function () {
                var $this = $(this)
                if (this.files && this.files[0]) {
                var reader = new FileReader();
                var fileName = this.files[0].name;
                reader.onload = function (e) {
                    $($this).closest('.input-image-preview').addClass('uploaded')
                    $($this).closest('.input-image-preview').find('.img-show').text(fileName).fadeIn();
                }
                reader.readAsDataURL(this.files[0]);
                }
            });

  // Input image 2
        $(".input-file-image-2").on('change', function () {
            var $this = $(this)
            if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                console.log($(this))
                $($this).closest('.input-image-preview').addClass('uploaded')
                $($this).closest('.input-image-preview').find('.img-show').attr('src', e.target.result).fadeIn();
            }
            reader.readAsDataURL(this.files[0]);
            }
        });
        // // Input image 3
        $(".input-file-image-3").on('change', function () {
            var $this = $(this)
            if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                console.log($(this))
                $($this).closest('.input-image-preview').addClass('uploaded')
                $($this).closest('.input-image-preview').find('.img-show').attr('src', e.target.result).fadeIn();
            }
            reader.readAsDataURL(this.files[0]);
            }
        });


        });
    </script>
@endpush
@endsection
