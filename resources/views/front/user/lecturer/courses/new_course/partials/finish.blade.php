
<div class="tab-pane fade show {{ @$is_active ? 'active' : '' }}" id="{{ @$key }}">
    <div class="row">
        <div class="col-12 d-flex flex-column align-items-center text-center">
            <img class="pt-2" src="{{ asset('assets/front/images/success.png') }}" alt="" loading="lazy"/>
            <h2 class="pt-2"><strong>شكراً لك!</strong></h2>
            <p class="pt-2">بقي أن تضغط على الزر للانتهاء</p>
            <div class="form-group pt-2">
                <button class="btn btn-primary px-5">حفظ</button>
            </div>
        </div>
    </div>
</div>
