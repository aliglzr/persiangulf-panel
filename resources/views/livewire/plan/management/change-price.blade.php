<div wire:ignore.self class="modal fade" id="changePrice">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تغییر قیمت</h5>
                </div>
                <div class="modal-body">

                    {{--                    @include('partials.general._notice',['color' => 'info','icon' => 'icons/duotune/general/gen044.svg','body' => 'درصورتی که قصد پرداخت با ارز دیجیتال دارید، لطفا تیکتی به پشتیبانی ارسال کنید', 'button' => true,'button_label' => 'ثبت تیکت','button_modal_id' => "#submit_ticket_modal"])--}}

                    <form class="form" wire:submit.prevent="changePrice()">
                        @csrf
                        <div class="form-group">
                            <label for="password"
                                   class="col-form-label fs-6 fw-bolder">درصد</label>
                            <div class="input-group mb-5">
                                <input wire:model.lazy="percent" type="text" id="inc_balance_input" class="form-control" placeholder="درصد" aria-label="درصد"
                                       aria-describedby="basic-addon1"/>
                                <span class="input-group-text" id="basic-addon1">
                                	<!--begin::Svg Icon | path: icons/duotune/general/gen061.svg-->
				            <span class="fa fa-percent svg-icon svg-icon-3"></span>
                                <!--end::Svg Icon-->
                            </span>
                            </div>
                            @error('percent')
                            <div class="text-danger">{{convertNumbers($message)}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password"
                                   class="col-form-label fs-6 fw-bolder">کد تایید احراز هویت دوعاملی</label>
                            <div class="input-group mb-5">
                                <input wire:model.lazy="two_factor" type="text" id="two_factor" class="form-control" placeholder="کد تایید احراز هویت دوعاملی" aria-label="کد تایید احراز هویت دوعاملی"
                                       aria-describedby="basic-addon1"/>
                                <span class="input-group-text" id="two_factor">
                                	<!--begin::Svg Icon | path: icons/duotune/general/gen061.svg-->
				            <span class="fa fa-lock svg-icon svg-icon-3"></span>
                                    <!--end::Svg Icon-->
                            </span>
                            </div>
                            @error('two_factor')
                            <div class="text-danger">{{convertNumbers($message)}}</div>
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
                        <div class="modal-footer d-flex justify-content-center align-items-center flex-row-reverse"
                             style="border-top-width: 0 !important;">
                            <button type="submit" wire:target="changePrice" wire:loading.attr="disabled" class="btn btn-primary">
                                <span class="indicator-label" wire:target="changePrice" wire:loading.class="d-none">تغییر</span>
                                <span class="indicator-progress" wire:target="changePrice" wire:loading.class="d-block">در حال تغییر
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
@push('scripts')
    <script>
        const changePriceModal = document.getElementById('changePrice')
        changePriceModal.addEventListener('hidden.bs.modal', event => {
        @this.resetModal();
        });
        document.addEventListener('toggleChangePriceModal',function () {
            $('#changePrice').modal('toggle');
        });
    </script>
@endpush

