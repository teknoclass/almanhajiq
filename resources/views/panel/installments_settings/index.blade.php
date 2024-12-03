@extends('panel.layouts.index',['sub_title' =>__('courses') ,'is_active'=>'courses'])
@section('contion')
    @php
        $item = isset($item) ? $item: null;
    @endphp
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @php
                $title_page=__('installments_settings');
                      
                        $breadcrumb_links=[
                        [
                        'title'=>__('home'),
                        'link'=>route('panel.home'),
                        ],
                        [
                        'title'=>__('courses'),
                        'link'=>route('panel.courses.all.index'),
                        ],
                        [
                        'title'=> @$item->title,
                        'link'=>route('panel.courses.edit.baseInformation.index', ['id' => @$item->id]),
                        ],
                        [
                        'title'=>$title_page,
                        'link'=>'#',
                        ],
                        ]
        @endphp
 @section('title', $title_page)
 <style>
        body {
            background-color: #f9f9f9;
        }

        .table-wrapper {
            background-color: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 99%;
            margin: auto;
        }

        .btn-custom {
            background-color: #ff6b6b;
            color: white;
            border-radius: 50px;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-custom:hover {
            background-color: #ff4a4a;
        }

        table {
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        table th, table td {
            vertical-align: middle;
            text-align: center;
        }

        table th {
            background-color: #ff6b6b;
            color: white;
            border-radius: 10px 10px 0 0;
            padding: 15px;
        }

        table td {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }
        #add-row-btn:hover {
            background-color: #45a049;
        }
        .delete-row-btn {
            background-color: #ff6b6b;
            border: none;
            border-radius: 50%;
            padding: 6px 10px;
            color: white;
        }

        .delete-row-btn:hover {
            background-color: #ff4a4a;
        }
    </style>
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
<!--begin::Container-->

   <div class="container">
       @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>__('courses'),])
      <div class="row">
         @include('panel.courses.partials.toolbar')

        <div class="table-wrapper mt-5">
            <h2 class="text-center mb-4">{{__('installments')}}</h2>
            <form id="installments-form">
                <table id="installments-table" class="table table-borderless">
                    <thead>
                        <tr>
                            <th>{{__('installment_name')}}</th>
                            <th>{{__('price')}}</th>
                            <th>{{__('lesson_content')}}</th>
                            <th>{{__('action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($installments as $installment)
                      @if(!checkIfInstallmentHasStudents($installment->id))
                      <tr>
                        <td><input type="text"  name="installment_name[]" required class="form-control" value="{{$installment->name}}"></td>
                        <td><input type="number" name="price[]" step="any" min="0" required class="form-control" value="{{$installment->price}}">
                        </td>
                        <td>
                            <select required name="lesson_id[]" class="form-control lessonsSelect">
                                @foreach($lessons as $lesson)
                               <option @if($installment->course_session_id == $lesson->id) selected @endif value="{{$lesson->id}}">{{$lesson->title}}</option>
                               @endforeach
                            </select>
                        </td>
                        <td><button type="button" class="delete-row-btn">{{__('delete')}}</button></td>
                    </tr>
                    @else 
                    <tr>
                        <td><input type="text" readonly name="installment_name[]"  class="form-control" value="{{$installment->name}}"></td>
                        <td><input type="number"  readonly name="price[]" step="any" min="0"  class="form-control" value="{{$installment->price}}">
                        </td>
                        <td>
                            <select class="form-control " name="lesson_id[]">
                                @foreach($lessons as $lesson)
                                @if($installment->course_session_id == $lesson->id) 
                               <option selected  value="{{$lesson->id}}">{{$lesson->title}}</option>
                               @endif
                               @endforeach
                            </select>
                        </td>
                        <td>{{__('cant_delete_or_edit')}}</td>
                    </tr>

                    @endif

                      @endforeach
                    </tbody>
                </table>

                <button type="button" id="add-row-btn" class="btn btn-primary">{{__('add')}}</button>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary submitBtn">{{__('save')}}</button>
                </div>
            </form>
        </div>
    </div>

      </div>
   </div>

</div>
    
    

    @push('panel_js')
            <script src="{{asset('assets/panel/js/post.js')}}"></script>
            <script src="{{asset('assets/panel/js/publish.js')}}"></script>
<script src="{{asset('assets/panel/js/schedule.js')}}"></script>
<script src="{{asset('assets/panel/js/schedule-groups.js')}}"></script>
 <script src="{{asset('assets/panel/js/pages/crud/forms/widgets/repeater.js')}}"></script>
<script src="{{asset('assets/panel/js/pages/crud/forms/widgets/form-repeater.js')}}"></script>
<script src="{{asset('assets/panel/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
@if( app()->isLocale('ar'))
        <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymce.js')}}?v=1"></script>
@else
        <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymceEN.js')}}?v=1"></script>
@endif
<script src="{{asset('assets/panel/js/pages/crud/forms/widgets/bootstrap-datetimepicker.js')}}"></script>
@include("panel.installments_settings.scripts")

@endpush
@stop
