@extends('front.layouts.index')
<title>  {{__('pay_bill')}} </title>
@section('content')

<div class="container" style="min-height:800px">
<div class="alert alert-danger">
            <h1>{{__('payment_failed')}}</h1>
            <p>{{__('payment_failed_txt')}}</p>
            
        </div>
</div>

@endsection