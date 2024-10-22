@extends('front.layouts.index', ['is_active' => 'Payment'])

@section('content')

    @push('front_css')
        <link href="{{ asset('assets/front/css/payment.css') }}" rel="stylesheet">
        <style>
            input#Field-numberInput{
                line-height: 2;
            }
        </style>
    @endpush

    <div class="container w-100 px-5">
        <div class="card m-4 mb-5">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">{{ __('Payment_On') }} <b>{{ $title }}</b></div>
                    <div class="col-6">{{ __('amount') }} <b> ( {{ $transaction->amount }}  {{ $currency }} ) </b></div>
                </div>

            </div>
            <div class="card-body">
                <form class="form-pument row mx-0" id="payment-form">
                    <div class="row">
                        <div class="col-12 my-1">
                            {{-- <h2>Pay Here</h2> --}}
                            <div class="stripe-payment-method  row mx-0 my-5" id="payment-element">
                            </div>
                        </div>

                        <div class="col-12 text-center">
                            <button id="submit"  class="btn btn-primary px-5 rounded-5 w-25">
                                <div class="spinner hidden" id="spinner"></div>
                                <span id="button-text">اتمام الدفع </span>
                            </button>
                            <div id="payment-message" class="hidden"></div>
                            <input type="hidden" value="{{$transaction->id}}" name="transaction_id" id="transaction_id">
                        </div>
                    </div>
                </form>
            </div>
          </div>

    </div>

    @push('front_js')
        <script src="https://js.stripe.com/v3/"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            var key              = "{{ $stripe_key }}"; // test
            console.log('key stripe : '+ key);
            // var key              = "{{ env('STRIPE_SECRET') }}"; // published

            var transaction_id   = "{{ $transaction->id }}";
        </script>
        <script src="{{ asset('assets/front/js/checkout.js') }}" defer></script>
    @endpush
@endsection
