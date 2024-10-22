@php
    $url_package = route('packages.single', ['id' => @$package->id, 'title' => mergeString(preg_replace('/[\w\h-](*SKIP)(*FAIL)|./u', '', @$package->title), '')]);
    $url_package_subscribe = route('user.packages.index');
@endphp
<div class="col-md-6 col-lg-4 col-sm-12 ">
    <div class="courses-content">
        <div class="mb-2 mx-1 single-courses" style="min-height: 260px">
            <div class="item-courses badge-parent">
                @if(@$package->type == 'best_seller')
                    <div class="badge-overlay">
                        <span class="badge2" style="background-color: {{ @$package->color }}">{{ __('Best Sale') }}</span>
                    </div>
                @endif
                <div class="courses-content">
                    <span class="title">
                        <a href="{{ @$url_package }}">
                            {{ @$package->title }}
                        </a>
                    </span>
                    <div class="courses-meta">
                        <span
                            class="text-color-muted">{!! Illuminate\Support\Str::limit(strip_tags($package->description), $limit = 71, $end = '...') !!}</span>
                    </div>
                    <div class="info">
                        <div class="info-item d-flex gap-2 mb-2">
                            <div class="image">
                                <svg width="21" height="22" viewBox="0 0 21 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17.9863 13.0488L19.9631 16.4735C20.0444 16.6146 20.0903 16.7732 20.0969 16.9358C20.1035 17.0985 20.0705 17.2603 20.0008 17.4074C19.9311 17.5546 19.8268 17.6826 19.6967 17.7805C19.5667 17.8784 19.4148 17.9434 19.2542 17.9697L19.1406 17.9808L19.0279 17.9798L16.0788 17.7887L14.7687 20.4392C14.6975 20.5827 14.5932 20.7072 14.4643 20.8023C14.3354 20.8974 14.1856 20.9603 14.0275 20.9859C13.8694 21.0114 13.7074 20.9989 13.5551 20.9493C13.4028 20.8997 13.2646 20.8144 13.1518 20.7006L13.0694 20.6061L12.997 20.4955L11.0182 17.0698C12.4112 16.9827 13.7651 16.5744 14.974 15.8768C16.1828 15.1792 17.2138 14.2113 17.9863 13.0488Z"
                                        stroke="#051242" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M9.87595 17.0698L7.89914 20.4965C7.81904 20.6354 7.70694 20.753 7.57217 20.8398C7.4374 20.9266 7.28386 20.9799 7.12433 20.9953C6.9648 21.0108 6.80388 20.9879 6.65497 20.9286C6.50607 20.8693 6.37348 20.7753 6.26823 20.6544L6.19182 20.5538L6.12746 20.4392L4.8163 17.7897L1.8692 17.9808C1.70686 17.9912 1.54441 17.9622 1.39576 17.8961C1.24711 17.83 1.11669 17.7289 1.01568 17.6014C0.914659 17.4739 0.846053 17.3238 0.815733 17.1639C0.785413 17.0041 0.794283 16.8393 0.841585 16.6837L0.881804 16.5761L0.932079 16.4756L2.91089 13.0478C3.68278 14.2103 4.71321 15.1784 5.92154 15.8763C7.12986 16.5742 8.48331 16.982 9.87595 17.0698Z"
                                        stroke="#051242" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M10.4491 1L10.6904 1.00402C12.5143 1.06659 14.2425 1.83512 15.5107 3.1475C16.7788 4.45989 17.4876 6.2135 17.4875 8.03846L17.4845 8.23252L17.4775 8.42557L17.4594 8.67192L17.4332 8.91525L17.4091 9.09422C17.3429 9.52824 17.2362 9.9551 17.0904 10.3692L16.9737 10.6789L16.8199 11.0288C16.2506 12.2414 15.3472 13.2664 14.2157 13.9835C13.0842 14.7005 11.7716 15.0799 10.4321 15.0769C9.0925 15.074 7.78158 14.6888 6.65326 13.9668C5.52494 13.2448 4.62606 12.2158 4.06218 11.0006L3.93147 10.702L3.87918 10.5683L3.79874 10.3501L3.70322 10.0545C3.6691 9.93999 3.63792 9.82466 3.60971 9.70858L3.54938 9.43609L3.50011 9.1636L3.48 9.02384L3.44079 8.69906L3.41665 8.33206L3.41062 8.03846C3.41059 6.2135 4.11939 4.45989 5.3875 3.1475C6.65561 1.83512 8.38388 1.06659 10.2078 1.00402L10.4491 1Z"
                                        stroke="#051242" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                                {!!  @$package->num_months ? (__('For') . ' <b>' .@$package->num_months . '</b> '. __('Months')) : '' !!}
                            </div>
                        </div>
                    </div>
                    <div class="border-top d-flex align-items-center p-2">
                        <div class="courses-price flex-fill">
                            <span class="sale-parice font-bold text-color-third">{{ @$package->getPrice() }}</span>
                        </div>
                        <button type="submit" id="subscribe_package" data-id="{{ $package->id }}" class="primary-btn p-1 px-3"
                            @if(@$package->type == 'featured') style="background-color:{{ @$package->color }};border-color: {{ @$package->color }};" @endif
                        >
                            {{ __('subscribe') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('front_js')
    <script>
        $(document).on('click', '#subscribe_package', function (e) {
            e.preventDefault();
            var save_btn   = $('#subscribe_package');
            var package_id = $(this).data('id');
            $(save_btn).attr("disabled", true);
            $(save_btn).find('.spinner-border').show();

            swal({
                title: "<span class='info'>" + window.are_your_sure + "</span>",
                type: 'question',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: window.confirm_text + "",
                cancelButtonText: window.cancel_text + "",
                confirmButtonColor: '#56ace0',
                allowOutsideClick: false
            }).then(function(result) {
                if (result.value)
                {
                    $.ajax({
                        url:"{{ url('user/packages/book') }}/" + package_id,
                        type:'post',
                        dataType:'json',
                        headers:{
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success:function(response){
                            $('#load').hide();
                            $(save_btn).attr("disabled", false);
                            $(save_btn).find('.spinner-border').hide();
                            if (response.status) {
                                if(response.redirect_url){
                                    $('#load').show();
                                    window.location = response.redirect_url;
                                }else{
                                    customSweetAlert(
                                        'success',
                                        response.message,
                                        response.item,
                                        function (event) {
                                            $('#load').show();
                                            window.location = '';
                                        }
                                    );
                                }
                            } else {
                                customSweetAlert(
                                    'error',
                                    response.message,
                                    response.errors_object
                                );
                            }
                        },
                        error: function(jqXhr) {
                            $(save_btn).attr("disabled", false);
                            $(save_btn).find('.spinner-border').hide();
                            setCookie('back_url', window.location.href, 1);
                            customSweetAlert(
                                'warning',
                                'يرجي تسجيل الدخول أولاً',
                                ''
                                ,function (event) {
                                    $('#load').show();
                                    window.location.href = "{{ url('login') }}";
                                }
                            );
                        }
                    });
                }
            });
        });

        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }
    </script>
    @endpush
