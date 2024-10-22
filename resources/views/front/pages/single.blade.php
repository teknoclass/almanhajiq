@extends('front.layouts.index', ['is_active'=>'page','sub_title'=>@$item->title, ])

@section('content')
<!-- start:: section -->
@if (@$item->image)
<div>
    <img class="hero" src="{{ imageUrl(@$item->image) }}" alt="{{@$item->title}}" loading="lazy"/>
 </div>
@endif


<section class="section wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="content">
            <h2 class="mb-4 font-bold title-section title-sm bg-right">{{@$item->title}}</h2>
            <div class="mb-5">
                {!!@$item->text !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section><!-- end:: section -->
@endsection
