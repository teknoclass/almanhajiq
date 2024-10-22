@php
$lectureRate = ( $lecturer->reviews)->where('sourse_id', $lecturer->id)->where('sourse_type', 'user')->sum('rate');
$lectureRateCount = ($lecturer->reviews)->where('sourse_id', $lecturer->id)->where('sourse_type', 'user')->count('rate');
$lectureRateCount = round(fdiv($lectureRate, $lectureRateCount));
$lecturerSetting=$lecturer->lecturerSetting;

$lecturer_url = route('lecturerProfile.index',['id'=>$lecturer->id , 'name'=>mergeString(@$lecturer->name,'')]);
@endphp

      <div class="col-lg-4 mb-4">
        <div class="widget_item-teacher h-100 text-center bg-white">
          <div class="widget_item-image">
            <a href="{{ @$lecturer_url }}">
                <div class="widget_item-overlay d-flex align-items-end justify-content-center">
                    {{-- @if (@$lecturerSetting->facebook)
                    <a href="{{@$lecturerSetting->facebook }}"> <i class="fa-brands fa-facebook"></i></a>
                    @endif
                    @if (@$lecturerSetting->twitter)
                    <a href="{{@$lecturerSetting->twitter }}"> <i class="fa-brands fa-twitter"></i></a>
                    @endif
                    @if (@$lecturer->mobile)
                    <a href="{{@$lecturer->mobile}}"> <i class="fa-solid fa-phone"></i></a>
                    @endif --}}
                </div>
            </a>

            <a href="{{ @$lecturer_url }}"><img src="{{imageUrl(@$lecturer->image)}}" alt="{{ @$lecturer->name }}" loading="lazy"/></a>
          </div>
          <div class="widget_item-content p-3">
            <h4 class="font-medium widget_item-title mb-2">
                <a href="{{ @$lecturer_url }}">
                    {{@$lecturer->name}}
                    @if (@$lecturer->belongs_to_awael)
                        <img src="{{ asset('assets/front/images/verified.png') }}" style="width: 30px" loading="lazy"/>
                    @endif
                </a>
            </h4>
            <div class="data-rating d-flex align-items-center justify-content-center"><span class="d-flex"
              data-rating="{{@$lecturer->getRating()}}"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i
                class="far fa-star"></i><i class="far fa-star"></i></span><span class="pt-1">{{@$lecturer->getRating()}}</span></div>
            <h5 class="text-muted widget_item-jop">{{@$lecturerSetting->position }}</h5>
          </div>
        </div>
      </div>
