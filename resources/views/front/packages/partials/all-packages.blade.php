<div class="wow fadeInUp" id="accordion" data-wow-delay="0.2s">
    @if(isset($packages) && count(@$packages)>0)

        <div class="row">
            @foreach ($packages as $package)
                @include('front.packages.partials.package', ['package' => $package])
            @endforeach
        </div>

        <nav>
            {{@$packages->links('vendor.pagination.custom')}}
        </nav>
    @else

    @include('front.components.search_not_found',['no_found_data_text'=>__('no_found_packages')])

    @endif
</div>

