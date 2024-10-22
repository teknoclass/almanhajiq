<div class="table-container">
    <div class="col-12 d-flex justify-content-center align-items-center mb-3">
        @if (!$last_withdrawal_request && $retractable_balance > 0)
            <button class="btn btn-primary font-medium reset-form-and-show-modal" data-bs-toggle="modal"
                data-bs-target="#withdraw_profits">
                {{ __('withdraw_profits') }}
            </button>
        @endif
        <!-- Modal -->
        <div class="modal fade" id="withdraw_profits" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body px-4 px-lg-5">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h3 class="modal-title text-center font-medium mb-2">
                            {{ __('withdrawal_request') }}
                        </h3>
                        <form class="withdraw-profits-form" id="form" method="POST"
                            action="{{ route('user.lecturer.financialRecord.withdrawalRequests.store') }}"
                            to="{{ url()->current() }}">
                            @csrf
                            <div class="form-group">
                                <label class="mb-1">
                                    {{ __('enter_the_amount_to_be_withdrawn') }}
                                </label>
                                <div class="input-icon left">
                                    <input type="text" class="form-control" required name="amount"
                                        placeholder="{{ __('amount') }}">
                                    <div class="icon">
                                        $ </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="mb-1">
                                    {{ __('receipt_method') }}
                                </label>
                                <div class="d-flex align-items-center">
                                    @foreach (config('constants.withdrawal_methods') as $method)
                                        <label class="m-radio mb-0 ms-5">
                                            <input type="radio" value="{{ $method['key'] }}"
                                                {{ $method['is_default'] ? 'checked' : '' }}
                                                name="withdrawal_method" /><span class="checkmark"></span>

                                            {{ __('withdrawal_method.' . $method['key']) }}
                                        </label>
                                    @endforeach

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="mb-1">
                                    {{ __('details') }}
                                </label>
                                <textarea class="form-control p-3" name="details" rows="2" placeholder="{{ __('details') }}"></textarea>
                            </div>
                            <div class="form-group">
                                @include('front.components.btn_submit', ['btn_submit_text' => __('send')])

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($last_withdrawal_request)
        <div class="row mb-4">
            <div class="col-12">
                <div class="table-container py-0">
                    <table class="table table-borderless table-cart mb-0">
                        <tbody>
                            <tr>
                                <td><span><i class="fa-regular fa-clock ms-2"></i>
                                        {{ changeDateFormate(@$last_withdrawal_request->created_at) }}
                                    </span></td>
                                <td width="20%" class="text-primary font-medium">
                                    {{ @$last_withdrawal_request->amount }}
                                </td>
                                <td>
                                    {{ __('withdrawal_request') }}
                                </td>
                                <td> <span
                                        class="bg-orge rounded-pill px-4 text-white h-40 d-inline-flex align-items-center ">
                                        {{ __('withdrawal_request_status.' . @$last_withdrawal_request->status) }}
                                    </span> </td>
                                <td width="10%">
                                    <button type="button" class="p-1 text-muted bg-transparent confirm-post"
                                        data-url="{{ route('user.lecturer.financialRecord.withdrawalRequests.cancel') }}"
                                        data-is_relpad_page="true">
                                        <i class="fa-solid fa-circle-xmark fa-xl"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <table class="table table-cart tabel-2 mb-3">
        <thead>
            <tr>
                <td>
                    {{ __('date') }}
                </td>
                <td>
                    {{ __('amount') }}
                </td>
                <td>
                    {{ __('reason') }}
                </td>

            </tr>
        </thead>
        @if (count($balance_transactions) > 0)
            <tbody>
                @foreach ($balance_transactions as $balance_transaction)
                    @include('front.user.lecturer.financial_reports.records.partials.record')
                @endforeach

            </tbody>
        @else
            <tbody>
                <tr>
                    <td colspan="6">
                        @include('front.components.no_found_data', [
                            'no_found_data_text' => __('no_found_transactions'),
                        ])
                    </td>
                </tr>
        @endif
    </table>
    <nav>
        {{ @$balance_transactions->links('vendor.pagination.custom') }}
    </nav>
</div>
