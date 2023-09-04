<div wire:ignore>
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">تنظیمات پنل</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div class="collapse show">
            <!--begin::Form-->
            <form class="form fv-plugins-bootstrap5 fv-plugins-framework">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label for="app_url" class="col-lg-4 col-form-label fw-semibold fs-6">دامنه اصلی</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input id="app_url" type="text" wire:model.lazy="APP_URL"
                                   class="form-control @error('APP_URL') is-invalid @enderror form-control-lg form-control-solid">
                            @error('APP_URL')
                            <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label for="server_login_rate_limit" class="col-lg-4 col-form-label fw-semibold fs-6">فاصله زمانی مجاز برای ورود (به ثانیه)</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input id="server_login_rate_limit" type="text" wire:model.lazy="server_login_rate_limit"
                                   class="form-control @error('server_login_rate_limit') is-invalid @enderror form-control-lg form-control-solid">
                            @error('server_login_rate_limit')
                            <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label for="android_application_minimum_version" class="col-lg-4 col-form-label fw-semibold fs-6">حداقل ورژن اندروید</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input id="android_application_minimum_version" type="text" wire:model.lazy="android_application_minimum_version"
                                   class="form-control @error('android_application_minimum_version') is-invalid @enderror form-control-lg form-control-solid">
                            @error('android_application_minimum_version')
                            <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label for="android_application_current_version" class="col-lg-4 col-form-label fw-semibold fs-6">ورژن فعلی اپلیکیشن اندروید</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input id="android_application_current_version" type="text" wire:model.lazy="android_application_current_version"
                                   class="form-control @error('android_application_current_version') is-invalid @enderror form-control-lg form-control-solid">
                            @error('android_application_current_version')
                            <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label for="minimum_payment" class="col-lg-4 col-form-label fw-semibold fs-6">حداقل افزایش اعتبار</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input id="minimum_payment" type="text" wire:model.lazy="minimum_payment"
                                   class="form-control @error('minimum_payment') is-invalid @enderror form-control-lg form-control-solid">
                            @error('minimum_payment')
                            <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label for="inviter_profit_percent" class="col-lg-4 col-form-label fw-semibold fs-6">درصد سود مشتری دعوت کننده</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input id="inviter_profit_percent" type="text" wire:model.lazy="inviter_profit_percent"
                                   class="form-control @error('inviter_profit_percent') is-invalid @enderror form-control-lg form-control-solid">
                            @error('inviter_profit_percent')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label for="invited_profit_percent" class="col-lg-4 col-form-label fw-semibold fs-6">درصد سود مشتری دعوت شده</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input id="invited_profit_percent" type="text" wire:model.lazy="invited_profit_percent"
                                   class="form-control @error('invited_profit_percent') is-invalid @enderror form-control-lg form-control-solid">
                            @error('invited_profit_percent')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">پرداخت سود نمایندگان هنگام افزایش اعتبار</label>
                        <!--begin::Label-->
                        <!--begin::Label-->
                        <div class="col-lg-8 d-flex align-items-center">
                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                <input class="form-check-input w-45px h-30px" type="checkbox"
                                       wire:model.lazy="agent_profit_status" id="agent_profit_status">
                                <label class="form-check-label" for="agent_profit_status"></label>
                                @error('agent_profit_status')
                                <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <!--begin::Label-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">امکان پرداخت</label>
                        <!--begin::Label-->
                        <!--begin::Label-->
                        <div class="col-lg-8 d-flex align-items-center">
                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                <input class="form-check-input w-45px h-30px" type="checkbox"
                                       wire:model.lazy="payment_status" id="payment_status">
                                <label class="form-check-label" for="payment_status"></label>
                                @error('payment_status')
                                <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <!--begin::Label-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">امکان ثبت نماینده</label>
                        <!--begin::Label-->
                        <!--begin::Label-->
                        <div class="col-lg-8 d-flex align-items-center">
                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                <input class="form-check-input w-45px h-30px" type="checkbox"
                                       wire:model.lazy="register_agents_status" id="register_agents_status">
                                <label class="form-check-label" for="register_agents_status"></label>
                                @error('register_agents_status')
                                <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <!--begin::Label-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">امکان ثبت نام مشتریان</label>
                        <!--begin::Label-->
                        <!--begin::Label-->
                        <div class="col-lg-8 d-flex align-items-center">
                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                <input class="form-check-input w-45px h-30px" type="checkbox"
                                       wire:model.lazy="register_clients_status" id="register_clients_status">
                                <label class="form-check-label" for="register_clients_status"></label>
                                @error('register_clients_status')
                                <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <!--begin::Label-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">امکان ثبت اشتراک رزرو</label>
                        <!--begin::Label-->
                        <!--begin::Label-->
                        <div class="col-lg-8 d-flex align-items-center">
                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                <input class="form-check-input w-45px h-30px" type="checkbox"
                                       wire:model.lazy="buy_subscription_in_reserved" id="buy_subscription_in_reserved">
                                <label class="form-check-label" for="buy_subscription_in_reserved"></label>
                                @error('buy_subscription_in_reserved')
                                <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <!--begin::Label-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">وضعیت فروش</label>
                        <!--begin::Label-->
                        <!--begin::Label-->
                        <div class="col-lg-8 d-flex align-items-center">
                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                <input class="form-check-input w-45px h-30px" type="checkbox"
                                       wire:model.lazy="buy_plans_status" id="buy_plans_status">
                                <label class="form-check-label" for="buy_plans_status"></label>
                                @error('buy_plans_status')
                                <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <!--begin::Label-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">الزام تایید ایمیل مشتریان</label>
                        <!--begin::Label-->
                        <!--begin::Label-->
                        <div class="col-lg-8 d-flex align-items-center">
                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                <input class="form-check-input w-45px h-30px" type="checkbox"
                                       wire:model.lazy="clients_must_verify_email" id="clients_must_verify_email">
                                <label class="form-check-label" for="clients_must_verify_email"></label>
                                @error('clients_must_verify_email')
                                <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <!--begin::Label-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">حالت توسعه برنامه اندروید</label>
                        <!--begin::Label-->
                        <!--begin::Label-->
                        <div class="col-lg-8 d-flex align-items-center">
                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                <input class="form-check-input w-45px h-30px" type="checkbox"
                                       wire:model.lazy="application_maintenance_mode" id="application_maintenance_mode">
                                <label class="form-check-label" for="application_maintenance_mode"></label>
                                @error('application_maintenance_mode')
                                <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <!--begin::Label-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label for="android_application_minimum_version" class="col-lg-4 col-form-label fw-semibold fs-6">متن حالت توسعه برنامه اندروید</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input id="application_maintenance_message" type="text" wire:model.lazy="application_maintenance_message"
                                   class="form-control @error('application_maintenance_message') is-invalid @enderror form-control-lg form-control-solid">
                            @error('application_maintenance_message')
                            <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button wire:click.prevent="save()" class="btn btn-primary">ذخیره</button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
    <livewire:system.options.tutorial-links/>
    <livewire:system.options.auth-banner/>
    <livewire:system.options.referral-profits/>
    <livewire:system.notices.login-notice/>
    <livewire:system.notices.notice/>
</div>
@section('title')
    تنظیمات
@endsection
@section('description')
    تنظیمات
@endsection
