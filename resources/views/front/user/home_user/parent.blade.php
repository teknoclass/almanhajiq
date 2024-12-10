@extends('front.layouts.index', ['is_active' => 'home_user', 'sub_title' => __('home')])
@section('content')
    <section class="section wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            @php

                $statistics = [
                    [
                        'title' => __('sons'),
                        'currency' => '',
                        'value' => @$count_sons,
                        'icon' => 'user',
                        'href' => '',
                    ],
                  
                ];

            @endphp
            <div class="row mb-3">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="font-medium">
                            {{ __('home') }}
                        </h3>
                    </div>
                </div>
              
            </div>
            <div class="row gy-5 g-lg-3 my-4">
                @foreach ($statistics as $i => $statistic)
                    @include('front.components.lecturer_statistic_card', ['statistic' => $statistic,'i' => $i, 'column_width' => '4'])
                @endforeach
            </div>

            @if (count($sons) > 0)

            <div class="row text-start mb-3 pt-5 justify-content-between align-items-center">
                <div class="col-10">
                  <div class="d-lg-flex align-items-center justify-content-between">
                    <h2 class="font-medium">{{ __('sons') }}</h2>
                  </div>
                </div>
                <div class="col-2 mb-2 d-flex justify-content-end">
                    <a class="btn btn-primary font-medium me-auto" href="{{ route('user.marketer.customers.index') }}">{{ __('add_son') }}</a>
                </div>
            </div>
            <div class="table-container">
                <table class="table table-cart mb-3">
                    <thead>
                        <tr>
                            <th width="">{{ __('name') }}</th>
                          
                            <th>
                                {{ __('date_of_registration') }}
                            </th>

                            <th width="">
                                {{ __('courses_count') }}
                            </th>
                            <th>
                                {{__('courses_details')}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sons as $son)
                            <tr>
                                <td>
                                    {{ @$son->son->name }}
                                </td>
                               
                                <td>
                                    {{ @$son->son->created_at }}
                                </td>

                                <td>
                                <a class="btn btn-primary  btn-sm" href="{{route('user.parent.sons.courses',$son->son_id)}}">   {{ @$son->son->courses()->count() }} </a>
                                </td>
                                <td>
                                <a class="btn btn-primary  btn-sm" href="{{route('user.parent.sons.courses',$son->son_id)}}">   {{__('courses_details')}}</a>
                                </td>
                            </tr>
                            @empty
                        <tr>
                            <td colspan="4"  class="text-center">{{__('no_data')}}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </section>

    @push('front_js')
        <script>
            function copyText(element, element_text) {
                var $copyText = document.getElementById(element).innerText;

                var copyText = document.getElementById(element_text);

                // Select the text field
                copyText.select();
                copyText.setSelectionRange(0, 99999); // For mobile devices

                // Copy the text inside the text field
                document.execCommand("copy");
                toastr.success("{{ __('copy_completed_successfully') }}")
            }
        </script>
    @endpush
@endsection
