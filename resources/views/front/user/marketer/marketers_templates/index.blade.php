@extends('front.layouts.index' , ['is_active'=>'templates','sub_title'=>__('templates'), ])
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
                  {{__('templates')}}
                  </li>
                </ol>
              </div>



          <div class="row mt-5">
            <div class="col-12">
             <div class="all-data mb-5">
             @include('front.user.marketer.marketers_templates.partials.all')
             </div>
            </div>
          </div>
        </div>
      </section>

@push('front_js')
<script src="{{asset('assets/front/js/ajax_pagination.js')}}?v={{getVersionAssets()}}"></script>

@endpush


@endsection
