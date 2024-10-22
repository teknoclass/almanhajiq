<div class="col-xl-{{ @$column_width ? @$column_width : '4' }} col-md-4">
    @if (@$statistic['href'] && @$statistic['href'] != '')
        <a href="{{ @$statistic['href'] }}">
    @endif

    <div class="card h-100">
        <div class="card-body">
            <div class="d-flex gap-2 align-items-center">
                <div class="icon-statistics bg-statistics-{{ $i }}">
                    <img src="{{ asset('assets/front/images/statistics/' . $statistic['icon'] . '.svg') }}"
                        alt="" loading="lazy">
                </div>
                <div class="">
                    <h3 class="font-medium text-dark">
                        @php
                        if($statistic['type'] == 'financial-record'){
                            $amount = $statistic['value'];
                                if($user->country) {
                                    $amount = ceil($user->country->currency_exchange_rate*$amount);
                                    echo $amount . ' ' . $user->country->currency_name . '<br>' . '(' . $statistic['value'] .' $)';
                                }else {
                                    echo $amount .' $';
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
