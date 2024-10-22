<div class="modal fade" id="reasonUnaccetapbleModal" tabindex="-1" aria-labelledby="reasonUnaccetapbleModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mb-2">
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="bg-white p-4 rounded-4">
                    <div class="row">
                        <div class="col-12 d-flex flex-column align-items-center text-center">
                            <img class="pt-2" src="{{ asset('assets/front/images/no_content.png') }}" alt="" loading="lazy"/>
                            <h2 class="pt-2"><strong>للأسف!</strong></h2>
                            <p class="pt-2">تم رفض الطلب الخاص بكم للسبب التالي:</p>
                            <strong><p class="pt-2" id="reasonUnaccetapbleModalText"></p></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
