<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">کیف پول تصفیه حساب</h3>
        </div>
        <!--end::Card title-->
    </div>
    <div id="kt_account_profile_details" class="collapse show">
        <!--begin::Form-->
        <form class="form" wire:submit.prevent="submit">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                        <span class="required">آدرس کیف پول تتر</span>
                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                           title="از درستی آدرس کیف پول و شبکه انتخابی مطمئن شوید، وبسایت هیچ مسئولیتی در قبال ورود آدرس اشتباه و از دست رفتن سرمایه شما ندارد."></i>
                    </label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <!--begin::Input wrapper-->
                        <div class="position-relative">
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" placeholder="US Tether wallet address" wire:model.lazy="wallet_address"/>
                            <!--end::Input-->

                            <!--begin::CVV icon-->
                            <div class="position-absolute translate-middle-y top-50 end-0 me-3">
                                <!--begin::Svg Icon | path: icons/duotune/finance/fin002.svg-->
                                {!! get_svg_icon('icons/duotune/finance/fin002.svg','svg-icon svg-icon-2hx') !!}
                                <!--end::Svg Icon-->
                            </div>
                            <!--end::CVV icon-->
                        </div>
                        <!--end::Input wrapper-->
                        @error('wallet_address')
                        <div class="invalid-feedback">{{$message}}</div> @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                        <span class="required">شبکه انتقال</span>
                    </label>
                    <!--end::Label-->

                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <!--begin::Radio group-->
                        <div wire:ignore.self class="btn-group w-100 w-lg-25" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                            <!--begin::Radio-->
                            <label wire:ignore.self class="btn btn-outline btn-color-muted btn-active-primary {{$user->getData('wallet_network') == 'TRC-20' ? 'active' : ''}}" data-kt-button="true">
                                <!--begin::Input-->
                                <input class="btn-check" type="radio" wire:model.lazy="wallet_network" value="TRC-20" checked="{{$user->getData('wallet_network') == 'TRC-20' ? 'checked' : ''}}"/>
                                <!--end::Input-->
                                TRC-20
                            </label>
                            <!--end::Radio-->


                            <!--begin::Radio-->
                            <label wire:ignore.self class="btn btn-outline btn-color-muted btn-active-info {{$user->getData('wallet_network') == 'ERC-20' ? 'active' : ''}}" data-kt-button="true">
                                <!--begin::Input-->
                                <input class="btn-check" type="radio" wire:model.lazy="wallet_network" value="ERC-20" checked="{{$user->getData('wallet_network') == 'ERC-20' ? 'checked' : ''}}" />
                                <!--end::Input-->
                                ERC-20
                            </label>
                            <!--end::Radio-->
                        </div>
                        <!--end::Radio group-->
                        @error('wallet_network')
                        <div class="invalid-feedback">{{$message}}</div> @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

            </div>
            <!--end::Card body-->

            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">

                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">
               <span class="indicator-label">
 ثبت
               </span>
                    <span class="indicator-progress">
                        در حال ثبت
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
</span>
                </button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
</div>

@push('scripts')

@endpush
