@extends('front.layouts.index', ['is_active' => 'packages', 'sub_title' => __('packages')])

@section('content')
    @push('front_css')
        <style>
            .badge-parent {
                position: relative;
            }
            .badge-overlay {
                position: absolute;
                left: 0px;
                top: 0px;
                width: 100%;
                height: 100%;
                overflow: hidden;
                pointer-events: none;
            }

            .badge2 {
                color: white;
                /* padding: 7.5px 7.5px; */
                padding: 2px;
                font-size: 15px;
                font-family: "Poppins";
                text-align: center;
                /* background: #ed1b24; */
                position: absolute;
                top: 0;
                left: 0;
                transform: translateX(-30%) translateY(0%) rotate(-45deg);
                transform-origin: top right;
            }

            .badge2::before, .badge2::after {
                content: '';
                position: absolute;
                top: 0;
                margin: 0 -1px;
                width: 100%;
                height: 100%;
                background: inherit;
                min-width: 55px;
            }

            .badge2::before {
                right: 100%
            }

            .badge2::after {
                left: 100%
            }

        </style>
    @endpush
    <section class="section-padding wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
                <div class="">
                    <div class="all-data">
                        @include('front.packages.partials.all-packages')
                    </div>
                </div>
        </div>
    </section>
    <!-- end:: section -->

    @push('front_js')
        <script src="{{ asset('assets/front/js/ajax_pagination.js') }}"></script>
        <script>
            var sideNav = document.querySelector('.filter-nav');
            var toggleButton = document.querySelector('.toggle-side-nav');
            var chevronIcon = document.getElementById('chevron-icon');

            toggleButton.addEventListener('click', function() {
                if (sideNav.style.display === 'none' || sideNav.style.display === '') {
                    sideNav.style.display = 'block';
                    chevronIcon.classList.remove('fa-chevron-down');
                    chevronIcon.classList.add('fa-chevron-up');
                } else {
                    sideNav.style.display = 'none';
                    chevronIcon.classList.remove('fa-chevron-up');
                    chevronIcon.classList.add('fa-chevron-down');
                }
            });
        </script>
        <script>
            $(document).on('submit', '.form-search-by-title', function(e) {
                e.preventDefault();
                filterLecturers();
            });
        </script>
    @endpush
@endsection
