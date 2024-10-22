<tr>
    <td data-title="{{ __('date') }}"><i class="fa-regular fa-clock ms-2"></i>
        {{ changeDateFormate(@$balance_transaction->created_at) }}
    </td>
    <td data-title="{{ __('amount') }}"
        class="{{ @$balance_transaction->type == 'deposit' ? 'text-success' : 'text-danger' }}  font-medium">
        {{ @$balance_transaction->amount }}
        @if (@$balance_transaction->type == 'deposit')
            +
        @else
            -
        @endif
    </td>
    <td data-title="{{ __('description') }}">
        {{ @$balance_transaction->description }}
    </td>
</tr>
