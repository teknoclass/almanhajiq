@extends('front.layouts.index' , ['is_active'=>'customers','sub_title'=>__('customers'), ])
@section('content')

<section class="section wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
          <div class="row mb-3">
            <div class="col-12">
              <div class="d-flex align-items-center justify-content-between">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="{{route('user.home.index')}}">
                    {{__('home')}}
                  </a></li>
                  <li class="breadcrumb-item active">
                  {{__('sons')}}
                  </li>
                 
                  <li class="breadcrumb-item active">
                  {{__('son_requests')}}
                  </li>
                </ol>
              </div>



          <div class="row">
            <div class="col-12">
             <div class="all-data">
          
             <div class="table-container">
                <table class="table table-cart mb-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="">{{ __('name') }}</th>
                         
                            <th>
                                {{__('mobile')}}
                            </th>

                            <th>{{ __('status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($son_requests as $k=>$son_request)
                            <tr>
                                <th>{{++$k}}</th>
                                <td>
                                    {{ @$son_request->son->name }}
                                </td>
                                <td>
                                    {{ @$son_request->son->mobile }}
                                </td>
                                <td>
                                {{__($son_request->status)}}
                                @if($son_request->status == 'pending')
                                    <button class="btn btn-primary btn-sm  updateStatus " data-id="{{ $son_request->id }}">{{__('confirm')}}</button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                        <tr>
                            <td colspan="9" class="text-center">{{__('no_data')}}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

             
             </div>
            </div>
          </div>
        </div>
      </section>

  
@endsection

@push('front_js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.updateStatus').forEach(button => {
            button.addEventListener('click', function () {
                let id = this.getAttribute('data-id'); 

                Swal.fire({
                    title: '{{ __("are_your_sure") }}',
                    text: '{{ __("update_status") }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '{{ __("confirm") }}',
                    cancelButtonText: '{{ __("cancel") }}',
                }).then((result) => {
                    if (result.value) {
                        fetch(`/user/parent/sons-requests/update/${id}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ status: 'updated' }) 
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status) {
                              customSweetAlert(
                                'success',
                                    '{{ __("done_operation") }}',
                                  
                                );
                                location.reload();
                            } else {
                              customSweetAlert(
                                'error',
                                    '{{ __("error") }}',
                                  
                                );
                            }
                        })
                        .catch(error => {
                          customSweetAlert(
                                'error',
                                    '{{ __("error") }}',
                                  
                                );
                        });
                    }
                });
            });
        });
    });
</script>
@endpush


