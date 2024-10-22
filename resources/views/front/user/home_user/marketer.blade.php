@extends('front.layouts.index', ['is_active' => 'home_user', 'sub_title' => __('home')])
@section('content')
    <section class="section wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            @php

                $statistics = [
                    [
                        'title' => __('customers'),
                        'currency' => '',
                        'value' => @$count_customers,
                        'icon' => 'user',
                        'href' => route('user.marketer.customers.index'),
                    ],
                    [
                        'title' => __('profits'),
                        'currency' => __('currency'),
                        'value' => @$profits,
                        'icon' => 'dollar',
                        'href' => route('user.financialRecord.index', ['user_type' => \App\Models\Balances::MARKETER]),
                    ],
                    [
                        'title' => __('withdrawable_amounts'),
                        'currency' => __('currency'),
                        'value' => @$withdrawable_amounts,
                        'icon' => 'dollar',
                        'href' => route('user.financialRecord.index', ['user_type' => \App\Models\Balances::MARKETER]),
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
                <div class="col-12 mt-4">
                    <div class="d-lg-flex d-block align-items-center justify-content-between row">
                        <div class="col-md-5">
                            <div class="input-group custome-input-group">
                                <input type="text" class="form-control" value="{{ @$coupon->code }}" id="coupon-code"
                                    disabled_>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" onclick="copyText('coupon-code-button','coupon-code');"
                                        id="coupon-code-button" type="button">
                                        {{ __('copy_coupon') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group custome-input-group">
                                <input type="text" class="form-control" id="registration-link"
                                    value="{{ route('user.auth.register') }}?coupon={{ @$coupon->code }}" disabled_>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button"
                                        onclick="copyText('registration-link-button','registration-link');"
                                        id="registration-link-button">
                                        {{ __('copy_the_registration_link') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gy-5 g-lg-3 my-4">
                @foreach ($statistics as $i => $statistic)
                    @include('front.components.lecturer_statistic_card', ['statistic' => $statistic,'i' => $i, 'column_width' => '4'])
                @endforeach
            </div>

            @if (count($last_customers) > 0)

            <div class="row text-start mb-3 pt-5 justify-content-between align-items-center">
                <div class="col-10">
                  <div class="d-lg-flex align-items-center justify-content-between">
                    <h2 class="font-medium">{{ __('last_customers') }}</h2>
                  </div>
                </div>
                <div class="col-2 mb-2 d-flex justify-content-end">
                    <a class="btn btn-primary font-medium me-auto" href="{{ route('user.marketer.customers.index') }}">{{ __('view_all') }}</a>
                </div>
            </div>
            <div class="table-container">
                <table class="table table-cart mb-3">
                    <thead>
                        <tr>
                            <td width="">{{ __('name') }}</td>
                            <td width="">
                                {{ __('last_login') }}
                            </td>
                            <td>
                                {{ __('date_of_registration') }}
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($last_customers as $customer)
                            <tr>
                                <td>
                                    {{ @$customer->name }}
                                </td>
                                <td>
                                    {{ @$customer->last_login_at }}
                                </td>
                                <td>
                                    {{ @$customer->created_at }}
                                </td>
                            </tr>
                        @endforeach
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
