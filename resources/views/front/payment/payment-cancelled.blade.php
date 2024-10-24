@extends('front.layouts.index')
<title>  {{__('pay_bill')}} </title>
@section('content')

<div class="container" style="min-height:800px">
<div class="alert alert-danger">
            <h1>{{__('payment_cancelled')}}</h1>
            <p>{{__('payment_cancelled_txt')}}</p>
            
        </div>
</div>

@endsection