@extends('front.layouts.index', ['is_active'=>'teachers','sub_title'=>'المدربين', ])

@section('content')
<!-- start:: section -->
<section class="section wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <div class="card slide-search">
            <div class="card-body">
              <div class="mb-4">
                <div class="filter-head">
                  <form class="form-search-by-title">
                    <div class="input-icon right">
                      <input class="form-control border-0 rounded_20"
                      id="search_by_title"
                      name="name"
                      value="{{request('name')}}"
                      type="text" placeholder="{{__('search')}}">
                      <div class="">
                        <button class="bg-transparent icon" type="submit">
                          <i class="fa-regular fa-magnifying-glass fa-lg"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="mb-4">
                <div class="form-group">
                  <h6 class="font-medium mb-2">جنس المدرب</h6>
                  <div class="d-flex align-items-center checkUser">
                    <label class="m-radio mb-0 me-5">
                      <input class="checkAllUsers" type="radio" name="radio"/><span class="checkmark"></span> ذكر
                    </label>
                    <label class="m-radio mb-0">
                      <input type="radio" checked="" name="radio"/><span class="checkmark"></span>أنثى
                    </label>
                  </div>
                </div>
              </div>







              <div class="mb-4">
                <div class="form-group">
                  <h6 class="font-medium mb-2">عمر المدرب</h6>
                  <select class="form-select @error('nationality')  is-invalid @enderror" name="nationality" aria-label="عمر المدرب">
                    <option value="">{{ old('nationality') }}</option>
                    <option value="">(20-24) سنة</option>
                    <option value="">(20-24) سنة</option>
                    <option value="">(20-24) سنة</option>
                    <option value="">(20-24) سنة</option>
                    <option value="">(20-24) سنة</option>
                    <option value="">(20-24) سنة</option>
                  </select>
                </div>
              </div>

              <div class="mb-4">
                <div class="form-group">
                  <h6 class="font-medium mb-2">الجنسية</h6>
                  <select class="form-select @error('nationality')  is-invalid @enderror" name="nationality" aria-label="الجنسية الأصل">
                    <option value="">{{ old('nationality') }}</option>
                    <option value="سوري">سوري</option>
                    <option value="مصري">مصري</option>
                    <option value="سعودي">سعودي</option>
                    <option value="لبناني">لبناني</option>
                    <option value="أردني">أردني</option>
                    <option value="فلسطيني">فلسطيني</option>
                    <option value="عراقي">عراقي</option>
                    <option value="كويتي">كويتي</option>
                    <option value="قطري">قطري</option>
                    <option value="بحريني">بحريني</option>
                    <option value="سوداني">سوداني</option>
                    <option value="عماني">عماني</option>
                    <option value="ليبي">ليبي</option>
                    <option value="يمني">يمني</option>
                    <option value="جزائري">جزائري</option>
                    <option value="مغربي">مغربي</option>
                    <option value="موريتاني">موريتاني</option>
                    <option value="إماراتي">إماراتي</option>
                    <option value="صومالي">صومالي</option>
                    <option value="غير ذلك">غير ذلك</option>
                  </select>
                </div>
              </div>

              <div class="mb-4">
                <div class="form-group">
                  <h6 class="font-medium mb-2">نوع اللقاء</h6>
                  <select class="form-select @error('nationality')  is-invalid @enderror" name="nationality" aria-label="نوع اللقاء">
                    <option value="">{{ old('nationality') }}</option>
                    <option value="">أونلاين</option>
                    <option value="">وجه لوجه</option>
                    <option value="">كلاهما</option>
                  </select>
                </div>
              </div>

              <div class="mb-4">
                <div class="form-group">
                  <h6 class="font-medium mb-2">المنهاج</h6>
                  <select class="form-select @error('nationality')  is-invalid @enderror" name="nationality" aria-label="المنهاج">
                    <option value="">{{ old('nationality') }}</option>
                    <option value="">التركي</option>
                    <option value="">السوري</option>
                    <option value="">المصري</option>
                  </select>
                </div>
              </div>


              <div class="mb-4">
                <div id="collapse">
                  <div class="collapse-filter mb-4">
                    <div class="collapse-head collapsed d-flex align-items-center justify-content-between" data-bs-toggle="collapse" data-bs-target="#collapse-2">
                      <div class="collapse-title">لغة المدرب</div>
                      <div class="collapse-icon"><i class="fa-solid fa-chevron-down"></i></div>
                    </div>
                    <div class="accordion-collapse collapse" id="collapse-2">
                      <div class="px-3 py-2">
                        <div class="form-group">
                          <div class="align-items-center checkUser">
                            <label class="m-radio mb-0 me-5">
                              <input class="checkAllUsers" type="radio" name="radio"/><span class="checkmark"></span>العربية
                            </label>
                            <label class="m-radio mb-0 me-5">
                              <input type="radio" checked="" name="radio"/><span class="checkmark"></span>الإنكليزية
                            </label>
                            <label class="m-radio mb-0 me-5">
                              <input type="radio" checked="" name="radio"/><span class="checkmark"></span>الفرنسية
                            </label>
                            <label class="m-radio mb-0 me-5">
                              <input type="radio" checked="" name="radio"/><span class="checkmark"></span>التركية
                            </label>
                            <label class="m-radio mb-0 me-5">
                              <input type="radio" checked="" name="radio"/><span class="checkmark"></span>الألمانية
                            </label>
                            <label class="m-radio mb-0 me-5">
                              <input type="radio" checked="" name="radio"/><span class="checkmark"></span>غير ذلك
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="collapse-filter mb-4">
                    <div class="collapse-head collapsed d-flex align-items-center justify-content-between" data-bs-toggle="collapse" data-bs-target="#collapse-1">
                      <div class="collapse-title"> التقييمات</div>
                      <div class="collapse-icon"><i class="fa-solid fa-chevron-down"></i></div>
                    </div>
                    <div class="accordion-collapse collapse" id="collapse-1">
                      <div class="px-3 py-2">
                        <div class="form-group">
                          <div class="align-items-center checkUser">
                            <label class="m-radio mb-0 me-5">
                              <input class="checkAllUsers" type="radio" name="radio"/><span class="checkmark"></span>
                              <div class="data-rating d-flex align-items-center rating-sm justify-content-center"><span class="d-flex" data-rating="1"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span></div>
                            </label>
                            <label class="m-radio mb-0">
                              <input type="radio" checked="" name="radio"/><span class="checkmark"></span>
                              <div class="data-rating d-flex align-items-center rating-sm justify-content-center"><span class="d-flex" data-rating="2"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span></div>
                            </label>
                            <label class="m-radio mb-0">
                              <input type="radio" checked="" name="radio"/><span class="checkmark"></span>
                              <div class="data-rating d-flex align-items-center rating-sm justify-content-center"><span class="d-flex" data-rating="3"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span></div>
                            </label>
                            <label class="m-radio mb-0">
                              <input type="radio" checked="" name="radio"/><span class="checkmark"></span>
                              <div class="data-rating d-flex align-items-center rating-sm justify-content-center"><span class="d-flex" data-rating="4"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span></div>
                            </label>
                            <label class="m-radio mb-0">
                              <input type="radio" checked="" name="radio"/><span class="checkmark"></span>
                              <div class="data-rating d-flex align-items-center rating-sm justify-content-center"><span class="d-flex" data-rating="5"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span></div>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-group mt-4 text-center">
                      <button class="btn btn-primary-2 rounded-pill font-medium" type="submit">إبحث</button>
                    </div>
                  </div>



                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="row">
            @php
//print_r(@$lecturers);
//dd(33);
            @endphp
            @foreach(@$lecturers as $lecturer)
              @php
              $user=$lecturer->user;

              @endphp



            <div class="col-lg-4 mb-4">
              <div class="widget_item-teacher h-100 text-center bg-white">
                <div class="widget_item-image">
                  <div class="widget_item-overlay d-flex align-items-end justify-content-center"><a href=""> <i class="fa-brands fa-facebook"></i></a><a href=""> <i class="fa-brands fa-twitter"></i></a><a href=""> <i class="fa-solid fa-phone"></i></a></div><a href=""><img src="{{imageUrl(@$lecturer->image)}}" alt=""/></a>
                </div>
                <div class="widget_item-content p-3">
                  <h4 class="font-medium widget_item-title mb-2"><a href="{{route('lecturerProfile.index',['id'=>$lecturer->id , 'name'=>mergeString(@$lecturer->name,'')])}}">{{@$lecturer->name}}</a></h4>
                  <div class="data-rating d-flex align-items-center rating-sm justify-content-center"><span class="d-flex" data-rating="3"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span><span>(2.4)</span></div>
                  <h5 class="text-muted widget_item-jop">تخصص المدرب</h5>
                </div>
              </div>
            </div>

            @endforeach



          </div>
          @if(count($lecturers)>1)
          <div class="row">
            <div class="col-12">
              <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
              </ul>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </section>
  <!-- end:: section -->
  @push('front_js')
<script src="{{asset('assets/front/js/ajax_pagination.js')}}?v={{getVersionAssets()}}"></script>
<script>
  $( document ).ready(function() {
    window.filter=getAttrFilter();
  });
  $(document).on('submit','.form-search-by-title',function(e){
    e.preventDefault();
    filterLecturers();
  });

  $(document).on('change','.filter-lecturers',function(){
    filterLecturers();
  });

  function  filterLecturers(){

      window.filter=getAttrFilter();
      var url="";
      getData(getUrlWithSearchParm(url,filter,false))

  }

  function getAttrFilter(){
    var search_by_title=$('#search_by_title').val();


    var filter={
          "name":checkisNotNull(search_by_title) ? search_by_title :'',
      }

      return filter;
  }


</script>
@endpush
@endsection
