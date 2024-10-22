<div class="col-12 mb-3">
	<div class="bg-white rounded-2 p-3 item-question">
		<h5 class="font-medium mb-3"><span class="square"></span> السؤال الأول : هذا النص هو مثال لنص يمكن أن يستبدل في نفس
			المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</h5>
		<textarea class="form-control p-3 rounded" rows="10" placeholder="..اكتب نصاً"></textarea>
	</div>
</div>
<div class="col-12 mb-3">
	<div class="bg-white rounded-2 p-3 item-question">
		<h5 class="font-medium mb-3"><span class="square"></span> السؤال الأول : هذا النص هو مثال لنص يمكن أن يستبدل في نفس
			المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</h5>
		<div class="dropzone myDropzone-1"></div>
	</div>
</div>



@push('front_css')
	<link rel="stylesheet" href="{{ asset('assets/front/css/dropzone.min.css') }}" />
@endpush


@push('front_js')
	<script src="{{ asset('assets/front/js/dropzone.min.js') }}"></script>
	<script>
		/*------------------------------------
	        Dropzone
	    --------------------------------------*/
		if ($(".myDropzone-1").length > 0) {
			var myDropzone = new Dropzone(".myDropzone-1", {
				url: "/file/post",
				dictDefaultMessage: `
            <span class='icon me-2'><i class="fa-solid fa-arrow-down-to-line"></i></span><span class='text'>إرفـاق ملفـات</span>`,
				acceptedFiles: 'image/*'
			});
		}
	</script>
@endpush
