 @foreach($reviews as $review)
    @php
    $user=$review->user;
    @endphp
    <div class="col-lg-6 grid-reviews">
        <div class="bg-white py-2 px-3 rounded-3 d-flex align-items-start mb-3">
            <div class="col">
            <div class="d-flex align-items-center">
                <div class="symbol symbol-60 px-2">
                    <img src="{{imageUrl( @$user->image )}}"class="rounded-circle" alt="{{ @$user->name }}" loading="lazy"/>
                </div>
                <div class="me-3">
                    <h5 class="mb-2">
                    {{ @$user->name }}
                    </h5>
                    <div class="data-rating d-flex align-items-center mb-2 rating-sm">
                        <span class="d-flex" data-rating="{{ @$review->rate }}">
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        </span>
                    </div>
                    <h6 class="text-gray">
                        {{ @$review->comment_text }}
                    </h6>
                </div>
            </div>
            </div>
            <div class="col-auto">
            <h6 class="text-gray pt-1">
                <i class="fa-regular fa-clock ms-2"></i>
                {{ changeDateFormate(@$review->created_at) }}
            </h6>
            </div>
        </div>
    </div>
@endforeach
