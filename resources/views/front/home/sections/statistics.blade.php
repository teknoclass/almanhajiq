@if (@$statistics && @$statistics->isNotEmpty())
    <!-- Statistics -->
    <section id="statistics" class="section-padding">
        <div>
            <div class="container pt-5 mt-4">
                <h2 class="position-relative mb-4 title-section">{{ __('our_platform_features') }}</h2>
                <div class="row">
                    @foreach ($statistics as $i => $statistic)
                        <div class="col-12 col-md-6 col-xl-4 mb-5">
                            <div class="box wow fadeInUp" data-wow-delay="{{$i+1/2}}s">
                                <div class="bg-box">
                                    <svg width="696" height="507" viewBox="0 0 396 307" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M65.707 4.98701C65.3424 2.56774 67.3264 0.5 69.8635 0.5H390.379C393.064 0.5 395.156 2.90191 394.843 5.58531C377.818 151.449 373.475 216.92 393.95 300.858C394.648 303.72 392.494 306.5 389.561 306.5H67.0288C65.7323 306.5 64.538 305.975 63.7052 305.002C56.3527 296.411 22.9819 256.298 8.3228 219.469C0.982964 201.028 -1.59177 183.592 5.89288 171.335C13.3567 159.112 30.9928 151.789 64.7395 153.999C82.2027 155.142 95.4757 154.58 105.307 152.593C115.135 150.606 121.582 147.184 125.315 142.558C129.059 137.917 130.004 132.148 129.009 125.627C128.015 119.117 125.081 111.814 121.01 104.028C115.194 92.9092 107.005 80.7172 98.7019 68.3549C95.3848 63.4161 92.0493 58.4501 88.8397 53.5145C77.566 36.1785 67.8542 19.2326 65.707 4.98701Z"
                                            fill="url(#paint0_linear_0_1)" stroke="#939393" />
                                        <path
                                            d="M72.4082 12.0672C71.9759 9.30404 74.246 7 77.0428 7H382.38C385.372 7 387.687 9.66924 387.34 12.6412C371.139 151.513 367.015 213.909 386.438 293.741C387.21 296.912 384.825 300 381.561 300H74.2085C72.7736 300 71.4176 299.394 70.4853 298.303C56.0898 281.46 -56.7378 145.071 71.9516 153.5C204.901 162.208 80.9944 66.9585 72.4082 12.0672Z"
                                            fill="white" />
                                        <defs>
                                            <linearGradient id="paint0_linear_0_1" x1="198.447" y1="0"
                                                x2="198.447" y2="307" gradientUnits="userSpaceOnUse">
                                                <stop offset="0.025" stop-color="#D89E53" stop-opacity="0.55" />
                                                <stop offset="0.265" stop-color="#D89E53" stop-opacity="0.65" />
                                                <stop offset="1" stop-color="#D89E53" stop-opacity="0.85" />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="info col-6 col-md-6 col-xl-8">
                                    <h5 class="title">
                                        {{ @$statistic->title }}
                                    </h5>
                                    <p>
                                        {{ @$statistic->count }}
                                    </p>
                                </div>
                                <div class="image">
                                    <img src="{{ imageUrl(@$statistic->image) }}" alt="{{ @$statistic->title }}"
                                        loading="lazy" />
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- Statistics End -->
@endif
