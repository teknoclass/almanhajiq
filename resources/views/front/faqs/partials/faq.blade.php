<div class="widget__item-faq rounded_15 p-0 mb-3 pointer px-3 px-lg-4 py-2 py-lg-3 collapsed"
        data-bs-toggle="collapse" data-bs-target="#faq-{{@$faq->id}}" aria-expanded="false">
        <div class="d-flex align-items-center">
            <svg class="me-3" xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16">
                <path id="arrow_icon" data-name="arrow icon"
                    d="M.352,23.461l15.785-7.385a.6.6,0,0,1,.726.172.619.619,0,0,1,.015.756L11.687,24.02l5.191,7.016a.62.62,0,0,1-.013.756.6.6,0,0,1-.472.229.6.6,0,0,1-.254-.057L.354,24.579a.619.619,0,0,1,0-1.118Z"
                    transform="translate(0 -16.02)" fill="#777777"></path>
            </svg>
            <h4 class="pointer title collapsed">{{@$faq->title}}</h4>
        </div>
        <div class="collapse" id="faq-{{@$faq->id}}" data-bs-parent="#accordion">
            <div class="pt-3 pb-2">
                <h5>
                    {!!@$faq->text !!}
                </h5>
            </div>
        </div>
    </div>

