<div class="table-container">

<table class="table table-cart tabel-2 mb-3">
   <thead>
      <tr>
         <td>
         {{__('date')}}    
         </td>
         <td>
         {{__('amount')}}    
         </td>
         <td>
         {{__('reason')}}    
         </td>

      </tr>
   </thead>
   @if(count($balance_transactions)>0)
   <tbody>
      @foreach($balance_transactions as $balance_transaction)
      @include('front.user.financial_record.partials.financial_record')
      @endforeach

   </tbody>
   @else
   <tbody>
      <tr>
         <td colspan="6">
            @include('front.components.no_found_data',['no_found_data_text'=>__('no_found_transactions')])
         </td>
      </tr>
      @endif
</table>
<nav>
   {{@$balance_transactions->links()}}
</nav>
</div>