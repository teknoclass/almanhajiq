<div class="col-xl-{{ @$column_width ? @$column_width : '4' }} col-md-4">
    @if (@$statistic['href'] && @$statistic['href'] != '')
        <a href="{{ @$statistic['href'] }}">
    @endif

    <div class="card h-100">
        <div class="card-body">
            <div class="d-flex gap-2 align-items-center">
                <div class="icon-statistics bg-statistics-{{ $i }}">
                    @if( $statistic['icon'] != "iqd")
                    <img src="{{ asset('assets/front/images/statistics/' . $statistic['icon'] . '.svg') }}"
                        alt="" loading="lazy">
                        @else 
                        <h3 style="text-align: center;color:white" class="fa fa-money-bill"></h3>
                        @endif
                </div>
                <div class="">
                    <h3 class="font-medium text-dark">
                        @php
                        if(@$statistic['type'] == 'financial-record'){
                            $amount = $statistic['value'];
                                if($user->country) {
                                    $amount = ceil($user->country->currency_exchange_rate*$amount);
                                    echo $amount . ' ' . __('currency') . '<br>' . '(' . $statistic['value'] .' )';
                                }else {
                                    echo $amount . __('currency');
                                }
                        }else{
                            echo $statistic['value'];
                        }
                        @endphp
                    </h3>
                    <p class="text-gray-500">{{ $statistic['title'] }}</p>
                </div>
            </div>
        </div>
    </div>

    @if (@$statistic['href'] && @$statistic['href'] != '')
        </a>
    @endif
</div>
