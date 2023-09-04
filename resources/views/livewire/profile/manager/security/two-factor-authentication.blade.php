<div>
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">احراز هویت دو عاملی</h3>
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_deactivate" class="collapse show">
            <!--begin::Form-->
            <form id="kt_account_deactivate_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                @if(!$user->has2faEnabled())
                    <!--begin::Notice-->
                        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                        {!! get_svg_icon('icons/duotune/general/gen044.svg','svg-icon svg-icon-2tx svg-icon-warning me-4') !!}
                        <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-grow-1">
                                <!--begin::Content-->
                                <div class="fw-semibold">
                                    <h4 class="text-gray-900 fw-bold">احراز هویت دو عاملی اکانت شما فعال نیست</h4>
                                    <div class="fs-6 text-gray-700">برای امنیت بیشتر، پیشنهاد میکنیم احراز هویت دو عاملی خود را فعال کنید
                                    </div>
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->


                        </div>
                        <!--end::Notice-->
                @endif
                @if($user->has2faEnabled())
                    <!--begin::Notice-->
                        <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                        {!! get_svg_icon('icons/duotune/general/gen026.svg','svg-icon svg-icon-2tx svg-icon-primary me-4') !!}
                        <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-grow-1">
                                <!--begin::Content-->
                                <div class="fw-semibold">
                                    <h4 class="text-gray-900 fw-bold">احراز هویت دو عاملی فعال است</h4>
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->

                        </div>
                        <!--end::Notice-->
                    @endif
                </div>
                <!--end::Card body-->
            @if(!$user->has2faEnabled())
                <!--begin::Card footer-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button id="kt_account_deactivate_google_two_factor_authentication_submit" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_add_ask_google2fa_code"
                                onclick="event.preventDefault();" class="btn btn-primary fw-semibold">فعال کردن احراز هویت دو عاملی</button>
                    </div>
                    <!--end::Card footer-->
            @endif

            @if($user->has2faEnabled())
                <!--begin::Card footer-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button id="kt_account_deactivate_google_two_factor_authentication_submit" type="submit" class="btn btn-danger fw-semibold" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_add_ask_google2fa_code" onclick="event.preventDefault();">غیر فعال کردن احراز هویت دو عاملی</button>
                    </div>
                    <!--end::Card footer-->
                @endif
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
    <livewire:profile.manager.security.two-factor-authentication-modal :user="$user"/>
</div>
