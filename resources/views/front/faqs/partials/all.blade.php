
<div class="wow fadeInUp" id="accordion" data-wow-delay="0.2s">
    <h2 class="font-bold mb-3">{{ __('faqs') }}</h2>

    @if(count($faqs)>0)

    @foreach($faqs as $faq)

    @include('front.faqs.partials.faq')

    @endforeach

    <nav>
        {{@$faqs->links('vendor.pagination.custom')}}
    </nav>

    @else

    @include('front.components.no_found_data',['no_found_data_text'=>__('no_found_faqs')])

    @endif

</div>
