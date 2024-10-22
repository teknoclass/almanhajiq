@extends('front.layouts.index', ['is_active' => 'my_purchases', 'sub_title' => 'مشترياتي'])

@section('content')

<!-- start:: section -->
      <section class="section wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
          <div class="row mb-lg-4">
            <div class="col-12">
              <ol class="breadcrumb mb-lg-0">
                <li class="breadcrumb-item"><a href="{{ route('user.home.index') }}">الرئيسية</a></li>
                <li class="breadcrumb-item active">مشترياتي</li>
              </ol>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12">
              <div class="text-start">
                <div class="bg-white p-2 rounded-pill d-inline-block">
                  <div class="bg-light d-flex align-items-center px-3 py-2 rounded-pill"><img class="ms-2" src="assets/images/svg/dollar.svg" alt="" loading="lazy"/>
                    <h6>مجموع المشتريات</h6>
                    <h6 class="font-size-10 mx-2">/SAR</h6>
                    <h3 class="font-medium text-primary">318</h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-l2">
              <div class="table-container">
                <table class="table table-cart table-2 mb-3">
                  <thead>
                    <tr>
                      <td>اسم الدورة</td>
                      <td>تاريخ الاشتراك</td>
                      <td>نوع الدورة</td>
                      <td>السعر</td>
                      <td width="40%"></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td data-title="اسم المسابقة">البرمجة</td>
                      <td data-title="التاريخ"><span> <i class="fa-regular fa-clock ms-2"></i>06 \ 12 \ 2022</span></td>
                      <td data-title="المستوى">مسجلة</td>
                      <td data-title="التقييم">$45</td>
                      <td>
                        <button class="btn btn-outline-primary font-medium"> إسترداد المبلغ</button>
                        <button class="btn btn-outline-primary-2 font-medium me-3"><i class="fa-solid fa-download ms-2"></i>طباعة فاتورة</button>
                      </td>
                    </tr>
                    <tr>
                      <td data-title="اسم المسابقة">البرمجة</td>
                      <td data-title="التاريخ"><span> <i class="fa-regular fa-clock ms-2"></i>06 \ 12 \ 2022</span></td>
                      <td data-title="المستوى">مسجلة</td>
                      <td data-title="التقييم">$45</td>
                      <td>
                        <button class="btn btn-outline-primary font-medium"> إسترداد المبلغ</button>
                        <button class="btn btn-outline-primary-2 font-medium me-3"><i class="fa-solid fa-download ms-2"></i>طباعة فاتورة</button>
                      </td>
                    </tr>
                    <tr>
                      <td data-title="اسم المسابقة">البرمجة</td>
                      <td data-title="التاريخ"><span> <i class="fa-regular fa-clock ms-2"></i>06 \ 12 \ 2022</span></td>
                      <td data-title="المستوى">مسجلة</td>
                      <td data-title="التقييم">$45</td>
                      <td>
                        <button class="btn btn-outline-primary font-medium"> إسترداد المبلغ</button>
                        <button class="btn btn-outline-primary-2 font-medium me-3"><i class="fa-solid fa-download ms-2"></i>طباعة فاتورة</button>
                      </td>
                    </tr>
                    <tr>
                      <td data-title="اسم المسابقة">البرمجة</td>
                      <td data-title="التاريخ"><span> <i class="fa-regular fa-clock ms-2"></i>06 \ 12 \ 2022</span></td>
                      <td data-title="المستوى">مسجلة</td>
                      <td data-title="التقييم">$45</td>
                      <td>
                        <button class="btn btn-outline-primary font-medium"> إسترداد المبلغ</button>
                        <button class="btn btn-outline-primary-2 font-medium me-3"><i class="fa-solid fa-download ms-2"></i>طباعة فاتورة</button>
                      </td>
                    </tr>
                    <tr>
                      <td data-title="اسم المسابقة">البرمجة</td>
                      <td data-title="التاريخ"><span> <i class="fa-regular fa-clock ms-2"></i>06 \ 12 \ 2022</span></td>
                      <td data-title="المستوى">مسجلة</td>
                      <td data-title="التقييم">$45</td>
                      <td>
                        <button class="btn btn-outline-primary font-medium"> إسترداد المبلغ</button>
                        <button class="btn btn-outline-primary-2 font-medium me-3"><i class="fa-solid fa-download ms-2"></i>طباعة فاتورة</button>
                      </td>
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
@endsection
