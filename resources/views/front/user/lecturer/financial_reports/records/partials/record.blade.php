<tr>
    <td data-title="{{__('date')}}"><i class="fa-regular fa-clock ms-2"></i>
     {{changeDateFormate(@$balance_transaction->created_at)}}
     </td>
    <td data-title="{{__('amount')}}" class="{{@$balance_transaction->type=='deposit'?'text-success':'text-danger'}}  font-medium">

    @php
        $amount = $balance_transaction->amount;
            if($user->country) {
                //$amount = ceil($user->country->currency_exchange_rate*$amount);
                echo  $balance_transaction->amount .  __('currency');
            }
            else {
                echo $amount . __('currency');
            }
    @endphp

    @if(@$balance_transaction->type=='deposit')
      +
    </td>
    <td data-title="{{__('description')}}">
        {{__('subscribed_to')}} {{@$balance_transaction->description}}
    </td>
    @else
     -
    </td>
    <td data-title="{{__('description')}}">
        {{__(@$balance_transaction->description)}}
    </td>
    @endif

  </tr>
