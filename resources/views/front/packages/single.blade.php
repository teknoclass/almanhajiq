@extends('front.blog.layout.index', ['is_active' => 'blog', 'sub_title' => @$package->title])

@section('content')
@php
    $url_package_subscribe = route('user.packages.index');
@endphp
    <!-- start:: section -->
    <section class="section wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="blog-single-title mb-4">
                        <h2 class="font-bold text-color-primary">{{ @$package->title }}</h2>
                    </div>
                    <div class="blog-single-text mb-4">
                        {!! @$package->description !!}
                    </div>
                </div>
                    <div class="border-top d-flex align-items-center p-2">
                        <div class="courses-price flex-fill">
                            <span class="sale-parice font-bold text-color-third">{{ @$package->getPrice() }}</span>
                        </div>
                        <a href="{{ @$url_package_subscribe }}" class="primary-btn p-1 px-3">
                            {{ __('subscribe') }}
                        </a>
                    </div>
            </div>
        </div>
    </section>
    <!-- end:: section -->
@endsection
