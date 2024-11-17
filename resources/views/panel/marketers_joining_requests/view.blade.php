@extends('panel.layouts.index' , ['is_active'=>'marketers_joining_requests','sub_title'=>'طلبات الانضمام كمسوق' ])
@section('contion')
@php
$item = isset($item) ? $item: null;
@endphp
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
@php
$title_page='تفاصيل طلب الانضمام ';
$breadcrumb_links=[
[
'title'=>'الرئيسية',
'link'=>route('panel.home'),
],
[
'title'=>'تفاصيل طلب الانضمام ',
'link'=>route('panel.marketersJoiningRequests.all.index'),
],
]
@endphp
@include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>'تفاصيل طلب الانضمام ',])
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
   <!--begin::Container-->
   <!--begin::Form-->
   <form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}" url="{{url()->current()}}" class="w-100">
      @csrf
      <div class="container">
         <div class="row">
            <div class="col-md-7">
               <!--begin::Card-->
               <div class="card card-custom gutter-b example example-compact">
                  <div class="card-header">
                     <h3 class="card-title">
                        {{@$title_page}}
                     </h3>
                  </div>
                  <!--begin::Form-->
                  <div class="card-body">
                  <h2 class="mb-3">
                        البيانات الاساسية
                     </h2>
                     <table class="table table-hover">
                        <tr>
                           <td>
                              تاريخ الطلب
                           </td>
                           <td>
                              {{@$item->date}}
                           </td>
                        </tr>
                        <tr>
                           <td>
                              الاسم الكامل
                           </td>
                           <td>
                              {{@$item->name}}
                           </td>
                        </tr>
                         <tr>
                             <td>
                              الجنس
                             </td>
                             <td>
                                 {{__($item->gender)}}
                             </td>
                         </tr>

                        <tr>
                           <td>
                              الايميل
                           </td>
                           <td>
                              {{@$item->email}}
                           </td>
                        </tr>


                        <tr>
                           <td>
                              الجوال
                           </td>
                           <td>
                           {{@$item->code_country}}/{{@$item->mobile}}
                           </td>
                        </tr>
                        <tr>
                           <td>
                              الدولة
                           </td>
                           <td>
                              {{@$item->country->name}}
                           </td>
                        </tr>
                        <tr>
                           <td>
                              المدينة
                           </td>
                           <td>
                              {{@$item->city}}
                           </td>
                        </tr>
                         <tr>
                             <td>
                                 نبذة
                             </td>
                             <td>
                                 {{@$item->bio}}
                             </td>
                         </tr>


                        <tr>
                           <td>
                              الحالة
                           </td>
                           <td>
                              {{__(@$item->status)}}
                           </td>
                        </tr>
                        @if(@$item->status=='unacceptable' && $item->reason_unacceptable!='')
                        <tr>
                           <td>
                              سبب الرفض
                           </td>
                           <td>
                              {{__(@$item->reason_unacceptable)}}
                           </td>
                        </tr>
                        @endif

                     </table>

                     @if($item->bank)
                        @php
                        $bank_account_data=[
                          [
                           'title'=>'البنك',
                           'value'=>@$item->bank->name
                           ] ,
                           [
                           'title'=>'رقم الحساب',
                           'value'=>@$item->account_num
                           ] ,
                           [
                           'title'=>'الايبان',
                           'value'=>@$item->ipan
                           ] ,
                        ];
                        @endphp
                     <h2 class="mb-3">
                        بيانات الحساب البنكي
                     </h2>
                     <table class="table table-hover">
                        @foreach($bank_account_data as $account_data)
                        <tr>
                           <td>
                              {{@$account_data['title']}}
                           </td>
                           <td>
                              {{@$account_data['value']}}
                           </td>
                        </tr>
                        @endforeach
                     </table>

                     @endif


                     @if($item->paypal_email)
                        @php
                        $paypal_email_data=[
                          [
                           'title'=>'الحساب',
                           'value'=>@$item->paypal_email
                           ] ,

                        ];
                        @endphp
                     <h2 class="mb-3">
                         بيانات حساب بيبال
                     </h2>
                     <table class="table table-hover">
                        @foreach($paypal_email_data as $account_data)
                        <tr>
                           <td>
                              {{@$account_data['title']}}
                           </td>
                           <td>
                              {{@$account_data['value']}}
                           </td>
                        </tr>
                        @endforeach
                     </table>

                     @endif

                     @php
                     $socialAccounts=$item->socialAccounts;
                     $i=1
                     @endphp
                     @if(count($socialAccounts)>0)

                     <h2 class="mb-3">
                         بيانات حسابات السوشيال ميديا
                     </h2>
                     <table class="table table-hover">
                        <tr>
                           <td>
                              #
                           </td>
                           <td>
                              الموقع
                           </td>
                           <td>
                              عدد المتابعين
                           </td>
                           <td>
                              الرابط
                           </td>
                        </tr>
                        @foreach($socialAccounts as $socialAccount)
                        <tr>
                           <td>
                              {{@$i}}
                           </td>
                           <td>
                              {{@$socialAccount->socalMedia->name}}
                           </td>
                           <td>
                              {{@$socialAccount->num_followers}}
                           </td>
                           <td>
                              <a href="{{@$socialAccount->link}}" target="_blank">
                                 الرابط
                              </a>

                           </td>
                        </tr>
                        @endforeach
                     </table>

                     @endif




                  </div>
                  <!--end::Form-->
               </div>
               <!--end::Card-->
            </div>
            @if(@$item->status=='pending')
            <div class="col-md-5">
               <!--begin::Card-->
               <div class="card card-custom gutter-b example example-compact">
                  <div class="card-header">
                     <h3 class="card-title"> الإجراءات</h3>
                     <div class="card-toolbar">
                        @include('panel.components.btn_submit',['btn_submit_text'=>'حفظ'])

                        <a href="{{route('panel.sliders.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>
                     </div>
                  </div>
                  <!--begin::Form-->
                  <div class="card-body d-flex align-items-center   ">
                     <div class="row w-100">
                        <div class="col-md-12">
                           <div class="form-group w-100">
                              <label>الحالة
                              <span class="text-danger">*</span></label>
                              <select type="text" name="status" id="status" class="form-control"  required >
                                 <option value=""  selected disabled>اختر الحالة</option>
                                 @foreach(config('constants.marketers_joining_requests_status') as $status)
                                 <option value="{{@$status}}">
                                    {{__($status)}}
                                 </option>
                                 @endforeach
                              </select>
                           </div>
                        </div>

                        <div class="col-md-12  marketer-coupon" style="display: none;">
                        <div class="form-group w-100">
                              <label>الكوبون
                              <span class="text-danger">*</span></label>
                               <select name="coupon_id" class="form-control" title="يرجى اختيار الكوبون">
                                 <option selected disabled> يرجى اختيار الكوبون</option>
                                 @foreach($coupons as $coupon)
                                 <option value="{{@$coupon->id}}">
                                    {{@$coupon->title}}
                                 </option>
                                 @endforeach
                               </select>
                           </div>


                           <div class="form-group row">
                           <label class="col-4 col-form-label">
                           نوع نسبه المسوق
                           </label>
                           <div class="col-8 col-form-label">
                              <div class="radio-inline">
                                 <label class="radio radio-success">
                                 <input type="radio" name="marketer_amount_type" value="rate" checked  />
                                 <span></span>
                                 نسبة
                                 </label>
                                 <label class="radio radio-success">
                                 <input type="radio" name="marketer_amount_type" value="fixed"  />
                                 <span></span>
                                 ثابت
                                 </label>
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <label>قيمة المسوق
                           <span class="text-danger">*</span></label>
                           <input type="text" name="marketer_amount" class="form-control" value="{{isset($item)?@$item->marketer_amount:''}}" required />
                        </div>
                        <div class="form-group mt-2">
                           <label>قيمة المسوق من كل عمليه تسجيل طالب جديد
                           <span class="text-danger">*</span></label>
                           <input type="text" name="marketer_amount_of_registration" class="form-control" value="{{isset($item)?@$item->marketer_amount_of_registration:''}}" required />
                        </div>



                       </div>

                        <div class="col-md-12 reason-unacceptable" style="display:none">
                           <div class="form-group w-100">
                              <label>سبب الرفض
                              <span class="text-danger">*</span></label>
                              <textarea name="reason_unacceptable" required
                              class="form-control " ></textarea>
                           </div>
                        </div>

                     </div>
                  </div>
                  <!--end::Form-->
               </div>
               <!--end::Card-->
            </div>
            @endif


         </div>
      </div>
   </form>
</div>
@push('panel_js')
<script src="{{asset('assets/panel/js/post.js')}}"></script>
<script>
    $(document).on('change', '#status', function(event) {

        if($(this).val()=='unacceptable'){
            $('.reason-unacceptable').show();
            $('.marketer-coupon').hide();
        }else{
            $('.reason-unacceptable').hide();
            $('.marketer-coupon').show();
        }

    });


</script>
@endpush
@endsection
