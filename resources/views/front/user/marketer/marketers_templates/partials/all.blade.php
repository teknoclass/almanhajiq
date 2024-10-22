@if(count($templates)>0)
<div class="row">
   @foreach($templates as $template)
   <div class="col-6 col-md-4 col-lg-4">
      <div class="grid-item">
         <a class="grid-link" href="javascript:void(0)">
         <img src="{{imageUrl($template->background)}}" alt="{{@$template->name}} " loading="lazy"/>
         </a>
         <div class="grid-overlay d-flex align-items-center justify-content-center">
            <a class="grid-download" href="{{route('user.marketer.templates.download',['id'=>$template->id])}}"
            title="{{__('download')}} "
               download="download">
            <i class="fa-regular fa-arrow-down-to-bracket"> </i>
            </a>
         </div>
      </div>
   </div>
   @endforeach
   <div class="col-md-12">
      {{@$templates->links()}}
   </div>
</div>
@else
<div class="row">
   <div class="col-md-12">
      @include('front.components.no_found_data',['no_found_data_text'=>__('no_found')])
   </div>
</div>
@endif
