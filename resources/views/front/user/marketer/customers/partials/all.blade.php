<div class="table-container">

<table class="table table-cart tabel-2 mb-3">
   <thead>
      <tr>
      <td width="">{{__('name')}}</td>
                     <td width="">
                        {{__('last_login')}}
                     </td>
                     <td>
                        {{__('date_of_registration')}}
                     </td>
      </tr>
   </thead>
   @if(count($customers)>0)
   <tbody>
      @foreach($customers as $customer)
      @include('front.user.marketer.customers.partials.customer')
      @endforeach

   </tbody>
   @else
   <tbody>
      <tr>
         <td colspan="6">
            @include('front.components.no_found_data',['no_found_data_text'=>__('no_found')])
         </td>
      </tr>
      @endif
</table>
<nav>
   {{@$customers->links()}}
</nav>
</div>