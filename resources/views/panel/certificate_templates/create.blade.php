@extends('panel.layouts.index',['sub_title' =>__('certificate_templates') ,'is_active'=>'certificate_templates'])
@section('contion')
@push('panel_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<!--link href="{{asset('assets/panel/css/jquery-ui.min.css')}}" rel="stylesheet" type="text/css" /-->

<link href="{{asset('assets/panel/css/certificate_templete.css')}}" rel="stylesheet" type="text/css" >
<style>
	.busines-card {
        max-width: none;
        width: 100%;
        overflow: scroll;
    }

	.freetrans-text {
        width: 200px!important;
		border:1px solid #000;
	}

    .freetrans-text-course_name_location{
        width: 300px!important;
    }

	.freetrans-text-certificate_date{
        width: 150px!important;
    }

	.freetrans-text-certificate_date .template-text{
        font-size: 1.5vw !important;
    }
</style>

@endpush
@php
$item = isset($item) ? $item: null;
@endphp
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
@php
$title_page=__('add');
if(isset($item)){
$title_page=__('edit');
}
$breadcrumb_links=[
[
'title'=>__('home'),
'link'=>route('panel.home'),
],
[
'title'=>__('certificate_templates'),
'link'=>route('panel.certificateTemplates.all.index'),
],
[
'title'=>$title_page,
'link'=>'#',
],
]
@endphp
<div class="container">
    @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>'الصور ',])
</div>
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
   <!--begin::Container-->
   <!--begin::Form-->
   <form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}" url="{{url()->current()}}" class="w-100">
      @csrf
      <input type="hidden" value="{{@$item->background}}" name="background" id="image" />
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <!--begin::Card-->
               <div class="card card-custom gutter-b example example-compact">
                  <div class="card-header">
                     <h3 class="card-title">
                        {{@$title_page}}
                     </h3>
                     <div class="card-toolbar gap-2">
                        <button type="button" class="btn btn-primary save-card">{{__('save')}}</button>

                        @if(isset($item))
                        <a href="{{route('panel.certificateTemplates.certificateTestIssuance', $item->id)}}" class="btn btn-secondary mr-2">{{__('view')}}</a>
                        @endif
                        <a href="{{url()->current()}}" class="btn btn-secondary">{{__('cancel')}}</a>
                     </div>
                  </div>
                  <!--begin::Form-->
                  <div class="card-body">
                     <div class="form-group">
                        <label>{{__('address')}}
                        <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{isset($item)?@$item->name:''}}" required />
                     </div>
                     <div class="form-group ">
                        <label>{{__('deparemnt')}}
                        <span class="text-danger"></span></label>
                        <select id="course_category_id" name="course_category_id" class="form-control" >
                           <option value="" selected disabled>{{__('category_select')}}</option>
                           @foreach($course_categories as $course_category)
                           <option value="{{@$course_category->value}}" {{@$item->course_category_id==$course_category->value ?'selected' :''}}>{{@$course_category->name}} </option>
                           @endforeach
                        </select>

                        <p class="mt-1">
                           <strong >
                           (
                           اذا تريد القالب عام لا تحدد له قسم
                           )
                           </strong>
                        </p>
                     </div>

                     <div class="busines-card rounded mb-11">
                        <div class="busines-card-head border-bottom p-3 mb-3">
                           <div class="d-flex align-items-end justify-content-between">
                              <div class="card-toplpar">
                                 <!-- <button type="button" class="btn-toplpar" onclick="rightFont()"><i class="fa-solid fa-align-right"></i></button>
                                 <button type="button" class="btn-toplpar" onclick="centerFont()"><i class="fa-solid fa-align-center"></i></button>
                                 <button type="button"  class="btn-toplpar" onclick="leftFont()"><i class="fa-solid fa-align-left"></i></button>
                                 <button type="button"  class="btn-toplpar" onclick="underlineFont()"><i class="fa-solid fa-a"></i></button>
                                 <button type="button"  class="btn-toplpar" onclick="boldFont()"><i class="fa-solid fa-bold"></i></button>
                                 <button type="button"  class="btn-toplpar" onclick="italicFont()"><i class="fa-solid fa-italic"></i></button>
                                 <input onchange="colorFont(this.value)" type="color" class="input-color input-toplpar" value="#0000ff">-->
                              </div>
                           </div>
                           <div class="d-flex align-items-center justify-content-between gap-2 my-3">
                            <div class="d-flex gap-2 align-items-center">
                                 <input type="text" class="form-control input-freetrans" placeholder="أضف نصاً..." />
                                 <button style="overflow: visible;" class="btn btn-primary add-freetrans" type="button">{{__('add')}}</button>
                              </div>
                              <label for="upload" class="btn btn-primary mb-0">
                              <input type="file" id="upload" class="input-change-bg-card d-none fileupload">
                              <span>{{__("change_background")}}</span>
                              </label>
                           </div>
                           <div style="text-align: left; color: red; font-weight: bold">(مقاس الصورة يجب أن يكون كالآتي: عرض 1280 * ارتفاع 904)</div>
                        </div>
                        <div class="text-center content-card-front">
                           <div id="content" class="card-action-front">
                              <img src="{{isset($item)?imageUrl(@$item->background):'/assets/panel/media/certificate_templete.png'}}" alt="" class="bg-card">
                              @if(isset($item))
                                    @php
                                    $texts=$item->texts;
                                    @endphp
                                    @if(count($texts))
                                        @foreach($texts as $text)
                                            @php
                                            $coordinates=json_decode($text->coordinates);
                                            @endphp
                                            <div class="title-action">
                                                <div class="freetrans-text freetrans-text-{{$text->id}}"
                                                    data-id="{{$text->id}}" id="freetrans-text-{{$text->id}}"
                                                    data-rotate="{{$text->transform_css}}"
                                                    data-type="{{@$text->type}}"
                                                    style="transform: rotate({{$text->transform_css}}deg);
                                                    font-size:{{$text->font_size_css}}"
                                                    coordinates_left="{{@$coordinates->left}}"
                                                    coordinates_top="{{@$coordinates->top}}">

                                                    <div class="template-text" data-type="{{@$text->type}}" @if(@$text->type=='others') contenteditable="true" @endif>
                                                        {!!@$text->text!!}
                                                    </div>

                                                    @if(@$text->type=='others')
                                                        <div class="remove-text" ><i class="fa fa-times"></i></div>
                                                    @endif

                                                    <div class="action-move top-right"><img src="/assets/panel/media/move.svg" alt=""></div>
                                                    <div class="action-move bottom-left "><img src="/assets/panel/media/move.svg" alt=""></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                              @else

                                            @foreach(config('constants.fixed_texts_templates_certificates') as $text)
                                                <div class="title-action">
                                                    <div class="freetrans-text freetrans-text-{{$text['type']}}"
                                                        data-id="{{$text['type']}}"
                                                        id="freetrans-text-{{$text['type']}}"
                                                        coordinates_left="{{@$text['left']}}"
                                                        coordinates_top="{{@$text['top']}}">

                                                        <div  class="template-text"
                                                            contenteditable="false"
                                                            data-type="{{@$text['type']}}"
                                                            coordinates_left="{{@$text['left']}}"
                                                            coordinates_top="{{@$text['top']}}"
                                                            style="font-size:2vw ;"
                                                            >
                                                            {{@$text['title']}}
                                                        </div>
                                                        <div class="action-move top-right">
                                                            <img src="/assets/panel/media/move.svg" alt="">
                                                        </div>
                                                        <div class="action-move bottom-left ">
                                                            <img src="/assets/panel/media/move.svg" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                              @endif
                           </div>
                        </div>
                        <!--div class="business-card-footer">
                           <input onchange="zoomSlider(this.value)" min="3" max="8" type="range" class="ml-auto">
                        </div-->
                        <div class="border-top p-3 text-right mt-3 d-none">
                           <button class="btn btn-primary save-card" type="button">حفظ</button>
                        </div>
                     </div>
                  </div>
                  <!--end::Form-->
               </div>
               <!--end::Card-->
            </div>
         </div>
      </div>
   </form>
</div>
@push('panel_js')
<script src="{{asset('assets/panel/js/post.js')}}"></script>
<script src="{{asset('assets/panel/js/image-input.js')}}"></script>
<script src="{{asset('assets/panel/js/jquery-ui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/panel/js/jquery.ui.touch-punch.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/panel/js/jquery.ui.rotatable.js.js')}}" type="text/javascript"></script>

  <script>

   freetrans();




function freetrans () {
      $.each( $( ".freetrans-text" ), function(key, value) {
         var id=$(value).data('id');
         // var top=(Number($(value).attr('coordinates_top') ) /100) * $('.card-action-front').height();
         // var left=(Number($(value).attr('coordinates_left')) /100)* $('.card-action-front').width();
         var top=(Number($(value).attr('coordinates_top') ) ) ;
         var left=(Number($(value).attr('coordinates_left')) );
         var rotate=$(value).data('rotate');


           $("#freetrans-text-"+id ).resizable({
        resize: function(event, ui) {
         if ($(window).width() < 992){
            $(this).find('.template-text').find('*').css("font-size", ui.size.width * 0.020 + "vw");
         $(this).find('.template-text').css("font-size", ui.size.width * 0.020 + "vw")

         }else{
            $(this).find('.template-text').find('*').css("font-size", ui.size.width * 0.011 + "vw");
         $(this).find('.template-text').css("font-size", ui.size.width * 0.011 + "vw")
         }

      }
        }).rotatable({ wheel: false }).draggable({ handle: '.action-move',
         stop: function () {
         // var l = (   parseFloat(left / parseFloat($(this).closest('.card-action-front').width())) ) + "%" ;
         //  var t = (   parseFloat(top / parseFloat($(this).closest('.card-action-front').height())) ) + "%" ;
          var l = ( 100 * parseFloat($(this).position().left / parseFloat($(this).closest('.card-action-front').width())) ) + "%" ;
          var t = ( 100 * parseFloat($(this).position().top / parseFloat($(this).closest('.card-action-front').height())) ) + "%" ;
         $(this).css("left", l);
          $(this).css("top", t);
       }
      }).css({"top":top+'px', "left":left+'px' , "transform":'rotate('+rotate+'deg)'});


   });






   }
   </script>


<script>
   $(document).ready(function(){

      $('.save-card').on('click',function(){
      $('.remove-text').remove();
      $('.remove-text-2').remove();

      const texts = [];

        $.each( $( ".freetrans-text" ), function(key, value) {

            var position = $(value).position();
            var top=$(value).position().top ;
            var left=$(value).position().left ;

            var transform =getRotationDegrees($(value));
            //  ($(value).css('transform'));
            var font_size = ($(value).css('font-size'));
            var html=$(value).find('.template-text').html();
            var font_color = ($(value).find('font').attr('color'))?? '#000';
            var type=$(value).find('.template-text').data('type');

         texts.push({
                position:{
                  top:top,
                  left:left,
				  width:$(value).width(),
				  length:$(value).find('.template-text').text().trim().length,
                },
               // position:position,
                text:html,
                transform:transform,
                font_size:font_size,
                font_color:font_color,
                type:type
            });

        });
        console.log(texts);
        window.template_texts=texts;
        $('#form').submit();

      });


      //
      var count = 1
      $('.add-freetrans').on('click', function(){
        var $input =  $('.input-freetrans').val()
        $('#content').append(
          `<div class="title-action"><div class="freetrans-text freetrans-text-${count}"
          ><div  style="font:16px ;"
          contenteditable="true" class="template-text">${$('.input-freetrans').val()}
          </div><div class="remove-text-2" ><i class="fa fa-times"></i></div>
          <div class="action-move top-right"><img src="/assets/panel/media/move.svg" alt=""></div>
         <div class="action-move bottom-left "><img src="/assets/panel/media/move.svg" alt=""></div>
          </div></div>`
        );

        $(`.freetrans-text-${count}`).resizable({
        resize: function(event, ui) {
         if ($(window).width() < 992){
            $(this).find('.template-text').find('*').css("font-size", ui.size.width * 0.020 + "vw");
         $(this).find('.template-text').css("font-size", ui.size.width * 0.020 + "vw")

         }else{
            $(this).find('.template-text').find('*').css("font-size", ui.size.width * 0.011 + "vw");
         $(this).find('.template-text').css("font-size", ui.size.width * 0.011 + "vw")
         }

      }
      }).rotatable({ wheel: false }).draggable({ handle: '.action-move' }).css({"top":'50px', "left":'50px'});


        count ++
      });


      //
      $('.input-change-bg-card').on('change' , function(){
        var input = $(this)
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
            $('.bg-card').attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
        }
      });



      function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
            $('.bg-card').attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
        }
      }

      $(".input-change-bg-card").change(function() {
        readURL(this);
      });


    })
</script>
<!-- Start Chnage Font weight Bold -->
<script>
   function boldFont () {
     document.execCommand('bold', false, null);
   }
</script>
<!-- End Chnage Font Size -->
<!-- Start Chnage Font style italic  -->
<script>
   function italicFont () {
     document.execCommand('italic', false, null);
   }
</script>
<!-- End Chnage Font Size -->
<!-- Start Chnage text decoration underline  -->
<script>
   function underlineFont () {
     document.execCommand('underline', false, null);
   }
</script>
<!-- End Chnage text decoration underline -->
<!-- Start Chnage Font coolor  -->
<script>
   $(document).ready(function(){
     $('.input-color').on('blur', function() {
       document.execCommand('foreColor', false, $(this).val());
     });
   });
</script>
<!-- End Chnage Font coolor -->
<!-- Start Chnage Font coolor  -->
<script>
   function fontFamily (fontFamily) {
           document.execCommand('fontName', false, false);
           var font = window.getSelection().focusNode.parentNode;
           $(font).removeClass().toggleClass(fontFamily);

   }
</script>
<!-- End Chnage Font coolor -->
<!-- Start Chnage Font coolor  -->
<script>
   function fontSize (fontSize) {
     document.execCommand('fontSize', false, Number(fontSize));
     jQuery("font[size]").removeAttr("size").css("font-size", Number(fontSize)+'vw');
   }
</script>
<!-- End Chnage Font coolor -->
<!-- Start Chnage Font lineHeight  -->
<script>
   function lineHeight (lineHeight) {
     var $selectedValue = $('.title-action.selected .freetrans-text')
     $($selectedValue).css('line-height' , Number(lineHeight)+'px' );
   }
</script>
<!-- End Chnage Font lineHeight -->
<!-- Start Chnage Font align  -->
<script>
   function rightFont () {
     document.execCommand("JustifyRight", false, "");
   }
</script>
<script>
   function centerFont () {
     document.execCommand("justifyCenter", false, "");
   }
</script>
<script>
   function leftFont () {
     document.execCommand("JustifyLeft", false, "");
   }
</script>
<!-- End Chnage Font align -->
<script>
   $(document).on( 'click' , '.title-action' , function(e){
        $('.title-action').removeClass('selected')
        $(this).addClass('selected');
        $('.select-toplpar').prop('selectedIndex',0);
      });
</script>
<script>
   $(document).on('click', '.remove-text' , function(e){
        $(this).closest('.title-action').remove();
      });

      $(document).on('click', '.remove-text-2' , function(e){
        $(this).closest('.freetrans-text ').remove();
      });


</script>
<!-- Start Chnage Font coolor  -->
<script>
   function zoomSlider (zoomSlider) {
     $('#content').animate({ 'zoom': Number(zoomSlider) / 5 }, 400);
   }
</script>
<!-- End Chnage Font coolor -->

<script>
function getRotationDegrees(obj) {
    var matrix = obj.css("-webkit-transform") ||
    obj.css("-moz-transform")    ||
    obj.css("-ms-transform")     ||
    obj.css("-o-transform")      ||
    obj.css("transform");
    if(matrix !== 'none') {
        var values = matrix.split('(')[1].split(')')[0].split(',');
        var a = values[0];
        var b = values[1];
        var angle = Math.round(Math.atan2(b, a) * (180/Math.PI));
    } else { var angle = 0; }

    if(angle < 0) angle +=360;
    return angle;
}
</script>

@endpush
@stop