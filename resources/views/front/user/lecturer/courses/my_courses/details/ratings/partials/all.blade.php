<div class="wow fadeInUp" id="accordion" data-wow-delay="0.2s">
@if(count($reviews)>0)

    <table class="table table-cart mb-3">
        <thead>
            <tr>
                <td>{{ __("rating1") }}</td>
                <td>{{ __("rating_type") }}</td>
            </tr>
        </thead>
        <tbody>

            @foreach($reviews as $review)
              @include('front.user.lecturer.courses.my_courses.details.ratings.partials.review')
            @endforeach
        </tbody>
    </table>

    <nav>
        {{@$reviews->links('vendor.pagination.custom')}}
    </nav>
    {{-- <ul class="pagination mt-3">
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">4</a></li>
    </ul> --}}
@else

@include('front.components.no_found_data',['no_found_data_text'=>__('no_found_rating')])

@endif
</div>
