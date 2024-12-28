@extends('front.layouts.index', ['is_active' => 'Payment'])

@section('content')
@php
$id = $transaction->id;
@endphp
<div class="payment-options-container">
    <h2>{{__('select_payment_method')}}</h2>

    @if (getSeting('qi'))
        <div class="payment-option-card" id="credit-card">
            <img src="{{asset('assets/front/images/qi-logo.png')}}" alt="Credit Card">
            <h3>{{__('visa_master')}}</h3>

            <button
            style="color:white;font-size:16px;font-weight:normal"
        type="button"
                    class="btn-primary p-1 private-lesson-sub w-50"
                    data-id="{{ @$id }}"
                    data-payment_type="gateway"
                    data-is_relpad_page="true">
                    {{ __('select_method') }}
                </button>

        </div>
    @endif


    <div class="payment-option-card" id="credit-card">
        <img src="{{asset('assets/front/images/zain-cash.png')}}" alt="Credit Card">
        <h3>{{__('zain_cash')}}</h3>

        <button
        style="color:white;font-weight:normal"
        type="button"
        class="btn-primary p-1  @if($transaction->amount > 1000) private-lesson-sub @else disabledBtn @endif w-50"
        data-id="{{ @$id }}"
        data-payment_type="zaincash"
        data-is_relpad_page="true">
        @if($transaction->amount > 1000)
        {{ __('select_method') }}
        @else
        {{__('amount_must_exceed_1000_iqd')}}
        @endif
       </button>

    </div>

</div>

<style>


.payment-options-container {
    text-align: center;
    max-width: 600px;
    margin: auto;
}

.payment-options-container h2 {
    margin-bottom: 20px;
    color: #333;
}

.payment-option-card {
    background-color: #fff;
    padding: 20px;
    margin: 15px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
}

.payment-option-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.payment-option-card img {
    width: 80px;
    margin-bottom: 10px;
}

.payment-option-card h3 {
    margin: 10px 0;
    color: #555;
}
.disabledBtn {
  background-color: #ccc;
  color: red !important;
  cursor: not-allowed;
  border: 1px solid #aaa;
  opacity: 0.6;
  pointer-events: none;
  padding: 10px 20px;
  font-size: 16px;
  border-radius: 5px;
}

.disabledBtn:hover,
.disabledBtn:focus {
  background-color: #ccc;
  color: #666
}

</style>
@push('front_js')
    <script src="{{ asset('assets/front/js/post.js') }}"></script>

<script>

 $(document).ready(function(){
        $(document).on('click','.private-lesson-sub',function(){
            var id = "{{$id}}";
            var payment_type = $(this).data('payment_type');

            if(id != "")
            {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{url('/user/private-lesson-subscription')}}",
                data:{id:id,payment_type:payment_type},
                method: 'post',
                success: function (response) {
                    $('.sessionGroupId option[value="' + id + '"]').remove();
                    if(response.status_msg == "error")
                    {
                        customSweetAlert(
                            response.status_msg,
                            response.message,
                        );
                    }
                    window.location.href = response.payment_link;
                }
            });
            }else{
                customSweetAlert(
                        'error',
                         'اختر الوحدة من فضلك',
                    );
            }
        });

    });
</script>
@endpush

@endsection
