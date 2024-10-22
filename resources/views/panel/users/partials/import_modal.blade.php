<div class="modal fade" id="import_excel_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeSm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">استيراد الطلاب من إكسل </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row ">
                    <div class="alert-danger errors w-100 p-2" style="display:none">

                    </div>
                </div>
                <form id="import_excel" method="POST" action="" class="w-100">
                    @csrf
                    <div class="form-group">
                        <label>ارفق ملف الإكسل</label>
                        <input type="file" class="form-control form-control-solid" name="file" accept=".xlsx , .xls" />
                        <span class="form-text text-muted">
                            <a href="{{asset('assets\panel\excel_users_import_template.xlsx')}}" target="_black" download>
                                إضغط هنا لتنزيل ملف الاكسل
                            </a>
                        </span>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <button type="submit" class="btn btn-primary">استيرد</button>
            </div>
            </form>

            {{-- loader  --}}
            <div id="load" style="display: none;">
                <img id="loading-image" src="{{ asset('assets\panel\media\ajax-loader.gif') }}" /><br>
            </div>
        </div>
    </div>
</div>