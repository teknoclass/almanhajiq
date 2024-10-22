@if(count($lecturers)>0)

    @foreach($lecturers as $lecturer)

        @include('front.lecturers.partials.lecturer')

    @endforeach

    <nav>
      {{@$lecturers->links('vendor.pagination.custom')}}
    </nav>


@else

    @include('front.components.no_found_data',['no_found_data_text'=>__('no_found_users')])

@endif
