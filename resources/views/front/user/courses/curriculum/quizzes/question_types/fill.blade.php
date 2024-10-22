<div class="col-12 mb-3">
	<div class="bg-white rounded-2 p-3 item-question">
		<h5 class="font-medium mb-3">{{ $question->title }}</h5>
		<div class="row">
			<div class="col-lg-4">
				<div class="input-question">
					<input class="form-control rounded" type="text" name="question[{{ $question->id }}][answer]" placeholder="إكتب هنا" value="" />
				</div>
			</div>
		</div>
	</div>
</div>
