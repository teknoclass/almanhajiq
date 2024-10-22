@extends('front.layouts.index', ['is_active' => 'my_points', 'sub_title' => 'نقاطي'])

@section('content')
<!-- start:: section -->
<section class="section wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
      <div class="row mb-3">
        <div class="col-12">
          <div class="d-lg-flex align-items-center justify-content-between">
            <ol class="breadcrumb mb-lg-0">
              <li class="breadcrumb-item"><a href="{{ route('user.home.index') }}">الرئيسية</a></li>
              <li class="breadcrumb-item active">نقـاطي</li>
            </ol>
            <div class="d-flex align-items-center">
              <div class="d-flex align-items-center justify-content-between border rounded-pill px-3 me-2 py-1">
                <h4 class="font-medium me-4"> مجموع نقاطي :</h4>
                <h2 class="font-medium text-success">241</h2>
              </div>
              <button class="btn btn-primary font-medium" data-bs-toggle="modal" data-bs-target="#ModalPoint">إستبدال النقاط</button>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="table-container">
            <table class="table table-cart mb-3">
              <thead>
                <tr>
                  <td width="30%">التاريخ</td>
                  <td width="30%">النقاط</td>
                  <td>السبب</td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td data-title="التاريخ"><span><i class="fa-regular fa-clock me-2"></i>06 \ 12 \ 2022</span></td>
                  <td class="text-success font-medium" data-title="النقاط"> 150 +</td>
                  <td data-title="السبب">نسبة ربح (عمولة)</td>
                </tr>
                <tr>
                  <td data-title="التاريخ"><span><i class="fa-regular fa-clock me-2"></i>06 \ 12 \ 2022</span></td>
                  <td class="text-success font-medium" data-title="النقاط"> 150 +</td>
                  <td data-title="السبب">نسبة ربح (عمولة)</td>
                </tr>
                <tr>
                  <td data-title="التاريخ"><span><i class="fa-regular fa-clock me-2"></i>06 \ 12 \ 2022</span></td>
                  <td class="text-success font-medium" data-title="النقاط"> 150 +</td>
                  <td data-title="السبب">نسبة ربح (عمولة)</td>
                </tr>
                <tr>
                  <td data-title="التاريخ"><span><i class="fa-regular fa-clock me-2"></i>06 \ 12 \ 2022</span></td>
                  <td class="text-danger font-medium" data-title="النقاط"> 150 -</td>
                  <td data-title="السبب">نسبة ربح (عمولة)</td>
                </tr>
                <tr>
                  <td data-title="التاريخ"><span><i class="fa-regular fa-clock me-2"></i>06 \ 12 \ 2022</span></td>
                  <td class="text-danger font-medium" data-title="النقاط"> 150 -</td>
                  <td data-title="السبب">نسبة ربح (عمولة)</td>
                </tr>
                <tr>
                  <td data-title="التاريخ"><span><i class="fa-regular fa-clock me-2"></i>06 \ 12 \ 2022</span></td>
                  <td class="text-success font-medium" data-title="النقاط"> 150 +</td>
                  <td data-title="السبب">نسبة ربح (عمولة)</td>
                </tr>
                <tr>
                  <td data-title="التاريخ"><span><i class="fa-regular fa-clock me-2"></i>06 \ 12 \ 2022</span></td>
                  <td class="text-success font-medium" data-title="النقاط"> 150 +</td>
                  <td data-title="السبب">نسبة ربح (عمولة)</td>
                </tr>
              </tbody>
            </table>
            <ul class="pagination mt-3">
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">4</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
</section>
<!-- end:: section -->

<div class="modal fade" id="ModalPoint" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <div class="text-end">
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="px-4">
            <h3 class="mb-3 font-medium text-center">طلب إستبدال النقاط</h3>
            <form action="">
              <div class="form-group">
                <label class="mb-2">أدخل عدد النقاط التي تريد استبدالها </label>
                <input class="form-control" type="text" placeholder="عدد النقاط"/>
              </div>
              <div class="form-group">
                <label class="mb-2">أدخل الطلب المراد شرائه بنقاطك</label>
                <textarea class="form-control" rows="3" placeholder="الطلب"></textarea>
              </div>
              <div class="form-group">
                <button class="btn btn-primary w-100">تأكيد</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
