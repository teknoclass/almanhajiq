

    <!-- Start Modal-->
    <div class="modal fade" id="joinSession" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
            <div class="modal-body px-5 py-4">
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                <h2 class="text-center mb-4"><strong>إنضمام إلى الجلسة</strong></h2>
                <div class="form-group">
                    <label class="mb-2">URL</label>
                    <input class="form-control" type="text"/>
                </div>
                <div class="form-group">
                    <label class="mb-2">كلمة المرور (اختياري)</label>
                    <input class="form-control" type="text"/>
                    <label class="mt-2 text-muted">يمكنك استخدام رابط زوم أو أي رابط آخر</label>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary px-5">إنضمام</button>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- End Modal-->

    <!-- Start Modal-->
    <div class="modal fade" id="createSession" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
            <div class="modal-body px-5 py-4">
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                <h2 class="text-center mb-4"><strong>إنشاء رابط الجلسة</strong></h2>
                <div class="form-group">
                    <label class="mb-2">URL</label>
                    <input class="form-control" type="text"/>
                </div>
                <div class="form-group">
                    <label class="mb-2">كلمة المرور (اختياري)</label>
                    <input class="form-control" type="text"/>
                    <label class="mt-2 text-muted">يمكنك استخدام رابط زوم أو أي رابط آخر</label>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary px-5">إنشاء</button>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- End Modal-->

    <!-- Start Modal-->
    <div class="modal fade" id="contactStudent" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
            <div class="modal-body px-5 py-4">
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                <h2 class="text-center mb-4"><strong>معلومات التواصل مع الطالب</strong></h2>
                <div class="pb-3 pt-lg-5">
                    <div class="text-center">
                        <div class="symbol-120 symbol"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt="" loading="lazy"/>
                        </div>
                    </div>
                    <div class="text-center py-3">
                        <h4 class="font-medium">أ. محمد السيلاوي</h4>
                    </div>
                </div>

                <div class="d-lg-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center mb-2 mb-lg-0">
                        <h3>البريد الالكتروني:</h3>
                    </div>
                    <div class="d-flex align-items-center">
                        <p>alawael@gmail.com</p>
                    </div>
                </div>

                <div class="d-lg-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center mb-2 mb-lg-0">
                        <h3>الهاتف:</h3>
                    </div>
                    <div class="d-flex align-items-center">
                        <p>0123456789</p>
                    </div>
                </div>

                <div class="d-lg-flex align-items-center mt-4" style="justify-content: space-evenly;">
                    <div class="d-flex align-items-center mb-2 mb-lg-0">
                        <div class="form-group text-center">
                            <button class="btn btn-success px-5">إرسال رسالة</button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="form-group text-center">
                            <button class="btn btn-danger px-5">إغلاق</button>
                        </div>
                    </div>
                </div>


            </div>
            </div>
        </div>
    </div>
    <!-- End Modal-->
