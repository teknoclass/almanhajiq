<div class="wow fadeInUp" id="accordion" data-wow-delay="0.2s">
    @if(isset($userPackages) && count(@$userPackages)>0)

    <div class="table-responsive">
        <table class="table mobile-table table-row-dashed table-row-gray-200 align-middle gy-2 table-custom mb-1">
            <thead>
                <tr class="border-0">
                    <th>{{ __('name') }}</th>
                    <th>{{ __('price') }}</th>
                    <th>{{ __('num_hours') }}</th>
                    <th>{{ __('Subscribed') }}</th>
                    <th>{{ __('Remain') }}</th>
                    <th>{{ __('date') }}</th>
                    <th>{{ __('End Date') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($userPackages as $userpack)
                    @include('front.user.packages.partials.package')
                @empty

                @endforelse
            </tbody>
        </table>

        <nav>
            {{@$userPackages->links('vendor.pagination.custom')}}
        </nav>

    </div>
    @else

    @include('front.components.no_found_data',['no_found_data_text'=>__('no_found_lessons')])

    @endif
</div>

