<div wire:ignore.self class="modal fade" tabindex="-1" id="change_user_balance">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-gray-900">تغییر اعتبار حساب کاربری <span class="text-primary fw-bolder">{{$user->username}}</span></h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <span class="svg-icon svg-icon-1"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <form class="form" wire:submit.prevent="change()">
                        @csrf
                        <div class="form-group">
                            <label for="inc_balance_input"
                                   class="col-form-label fs-6 fw-bolder">مبلغ</label>
                            <div class="input-group mb-5">
                                <input wire:model.lazy="amount" type="text" class="form-control  @error('amount') is-invalid @enderror" placeholder="مبلغ" aria-label="مبلغ"
                                       aria-describedby="basic-addon1"/>
                                <span class="input-group-text" id="basic-addon1">
                                	<!--begin::Svg Icon | path: icons/duotune/general/gen061.svg-->
				            {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3') !!}
                                <!--end::Svg Icon-->
                            </span>
                            </div>
                            @error('amount')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <!--begin::Input group-->
                        <div class="form-group">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">انتخاب عملیات</label>
                            <!--begin::Label-->

                            <!--begin::Label-->
                            <div class="col-lg-8 d-flex align-items-center">
                                <!--begin::Radio group-->
                                <div wire:ignore.self class="btn-group w-100 w-lg-50" data-kt-buttons="true"
                                     data-kt-buttons-target="[data-kt-button]">
                                    <!--begin::Radio-->
                                    <label
                                        class="btn btn-outline btn-color-muted btn-active-primary {{$mode == 'increase' ? 'active' : ''}}"
                                        data-kt-button="true">
                                        <!--begin::Input-->
                                        <input class="btn-check" type="radio" wire:model.lazy="mode"
                                               value="increase" checked="{{$mode == 'increase' ? 'checked' : ''}}"/>
                                        <!--end::Input-->
                                        افزایش
                                    </label>
                                    <!--end::Radio-->


                                    <!--begin::Radio-->
                                    <label
                                        class="btn btn-outline btn-color-muted btn-active-danger {{$mode == 'decrease' ? 'active' : ''}}"
                                        data-kt-button="true">
                                        <!--begin::Input-->
                                        <input class="btn-check" type="radio" wire:model.lazy="mode"
                                               value="decrease" checked="{{$mode == 'decrease' ? 'checked' : ''}}"/>
                                        <!--end::Input-->
                                    کاهش
                                    </label>
                                    <!--end::Radio-->
                                </div>
                                <!--end::Radio group-->
                                @error('mode')
                                <div class="text-danger">{{$message}}</div> @enderror
                            </div>
                            <!--begin::Label-->
                        </div>
                        <!--end::Input group-->

                        <div class="form-group">
                            <label for="description"
                                   class="col-form-label fs-6 fw-bolder">توضیحات</label>
                            <div class="input-group mb-5">
                                <textarea wire:model.lazy="description" type="text" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="توضیحات" aria-label="توضیحات"
                                          aria-describedby="description"></textarea>
                            </div>
                            @error('description')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="modal-footer d-flex justify-content-center align-items-center flex-row-reverse"
                             style="border-top-width: 0 !important;">
                            <button type="submit" wire:target="change" wire:loading.attr="disabled" class="btn btn-primary">
                                <span class="indicator-label" wire:target="change" wire:loading.class="d-none">افزایش اعتبار</span>
                                <span class="indicator-progress" wire:target="change" wire:loading.class="d-block">در حال پردازش
														<span
                                                            class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <button type="button" wire:target="change" wire:loading.attr="disabled" class="btn btn-secondary font-weight-bold" data-bs-dismiss="modal"
                                    aria-label="Close">انصراف
                            </button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('closeModal',function () {
            $('#change_user_balance').modal('hide');
        });
        document.addEventListener('refreshTables',function () {
            let paymentsTable = window.window.LaravelDataTables['payments-table'];
            let transactionsTable = window.window.LaravelDataTables['transactions-table'];
            if (paymentsTable) {
                paymentsTable.ajax.reload();
            }
            if (transactionsTable) {
                transactionsTable.ajax.reload();
            }
        })
        const changeUserBalanceModal = document.getElementById('change_user_balance')
        changeUserBalanceModal.addEventListener('hidden.bs.modal', event => {
        @this.resetModal();
        });
    </script>
@endpush
