<div wire:ignore>
    <div class="modal fade" id="increaseCredit">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">افزایش اعتبار</h5>
                </div>
                <div class="modal-body">

{{--                    @include('partials.general._notice',['color' => 'info','icon' => 'icons/duotune/general/gen044.svg','body' => 'درصورتی که قصد پرداخت با ارز دیجیتال دارید، لطفا تیکتی به پشتیبانی ارسال کنید', 'button' => true,'button_label' => 'ثبت تیکت','button_modal_id' => "#submit_ticket_modal"])--}}

                    <form class="form" wire:submit.prevent="increase()">
                        @csrf
                        <div class="form-group">
                            <label for="password"
                                   class="col-form-label fs-6 fw-bolder">مبلغ</label>
                            <div class="input-group mb-5">
                                <input wire:model.lazy="amount" type="text" id="inc_balance_input" class="form-control" placeholder="مبلغ" aria-label="مبلغ"
                                       aria-describedby="basic-addon1"/>
                                <span class="input-group-text" id="basic-addon1">
                                	<!--begin::Svg Icon | path: icons/duotune/general/gen061.svg-->
				            {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3') !!}
                                <!--end::Svg Icon-->
                            </span>
                            </div>
                            <span class="form-text text-primary font-size-h6 mt-3" id="inc_balance_text">صفر تومان</span>
                        </div>
                        <div class="modal-footer d-flex justify-content-center align-items-center flex-row-reverse"
                             style="border-top-width: 0 !important;">
                            <button type="submit" wire:target="increase" wire:loading.attr="disabled" class="btn btn-primary">
                                <span class="indicator-label" wire:target="increase" wire:loading.class="d-none">پرداخت</span>
                                <span class="indicator-progress" wire:target="increase" wire:loading.class="d-block">در حال پردازش
														<span
                                                            class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <button type="button" wire:target="increase" wire:loading.attr="disabled" class="btn btn-secondary font-weight-bold" data-bs-dismiss="modal"
                                    aria-label="Close">انصراف
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
