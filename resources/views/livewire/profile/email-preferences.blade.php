<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
         data-bs-target="#kt_account_email_preferences" aria-expanded="true"
         aria-controls="kt_account_email_preferences">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">ارسال ایمیل</h3>
        </div>
        <div class="card-toolbar">
            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                <input class="form-check-input w-45px h-30px" type="checkbox"
                       wire:model.lazy="email_subscription" id="email_subscription">
                <label class="form-check-label" for="email_subscription"></label>
                @error('email_subscription')
                <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                @enderror
            </div>
        </div>
    </div>
    <!--begin::Card header-->
    <!--begin::Content-->
    <div class="collapse {{$email_subscription ? 'show' : ''}}">
        <!--begin::Card body-->
        <div class="card-body border-top px-9 py-9"
             wire:target="toggleEmailPreferencesValue"
             wire:loading.class="overlay overlay-block">
            <div wire:loading.class="overlay-wrapper" wire:target="toggleEmailPreferencesValue">
                <!--begin::Option-->
                <label class="form-check form-check-custom form-check-solid align-items-start">
                    <!--begin::Input-->
                    <input class="form-check-input me-3" type="checkbox"
                           {{$this->isChecked('payment_email_notification')}} onchange="@this.toggleEmailPreferencesValue('payment_email_notification',event.target.checked)">
                    <!--end::Input-->
                    <!--begin::Label-->
                    <span class="form-check-label d-flex flex-column align-items-start">
                                                <span class="fw-bold fs-5 mb-0">دریافت اطلاعیه پرداخت ها</span>
                                                <span class="text-muted fs-6">دریافت ایمیل در صورت دریافت تراکنش پرداخت و بررسی آن </span>
                                            </span>
                    <!--end::Label-->
                </label>
                <!--end::Option-->
                <!--begin::Option-->
                <div class="separator separator-dashed my-6"></div>
                <!--end::Option-->
                <!--begin::Option-->
                <label class="form-check form-check-custom form-check-solid align-items-start">
                    <!--begin::Input-->
                    <input class="form-check-input me-3" type="checkbox"
                           {{$this->isChecked('invoice_email_notification')}} onchange="@this.toggleEmailPreferencesValue('invoice_email_notification',event.target.checked)">
                    <!--end::Input-->
                    <!--begin::Label-->
                    <span class="form-check-label d-flex flex-column align-items-start">
                                                <span class="fw-bold fs-5 mb-0">دریافت اطلاعیه صورتحساب</span>
                                                <span class="text-muted fs-6">دریافت ایمیل در صورت خرید طرح و صدور فاکتور</span>
                                            </span>
                    <!--end::Label-->
                </label>
                <!--end::Option-->
                <!--begin::Option-->
                <div class="separator separator-dashed my-6"></div>
                <!--end::Option-->
                <!--begin::Option-->
                <label class="form-check form-check-custom form-check-solid align-items-start">
                    <!--begin::Input-->
                    <input class="form-check-input me-3" type="checkbox"
                           {{$this->isChecked('ticket_email_notification')}} onchange="@this.toggleEmailPreferencesValue('ticket_email_notification',event.target.checked)">
                    <!--end::Input-->
                    <!--begin::Label-->
                    <span class="form-check-label d-flex flex-column align-items-start">
                                                <span class="fw-bold fs-5 mb-0">دریافت اطلاعیه دریافت تیکت</span>
                                                <span class="text-muted fs-6">ارسال ایمیل به هنگام پاسخ از سمت پشتیبانی به تیکت شما</span>
                                            </span>
                    <!--end::Label-->
                </label>
                <!--end::Option-->
                <!--begin::Option-->
                <div class="separator separator-dashed my-6"></div>
                <!--end::Option-->
                <!--begin::Option-->
                <label class="form-check form-check-custom form-check-solid align-items-start">
                    <!--begin::Input-->
                    <input class="form-check-input me-3" type="checkbox"
                           {{$this->isChecked('discount_email_notification')}} onchange="@this.toggleEmailPreferencesValue('discount_email_notification',event.target.checked)">
                    <!--end::Input-->
                    <!--begin::Label-->
                    <span class="form-check-label d-flex flex-column align-items-start">
                                                <span class="fw-bold fs-5 mb-0">دریافت اطلاعیه تخفیف</span>
                                                <span class="text-muted fs-6">دریافت ایمیل در صورت دریافت کد تخفیف جدید</span>
                                            </span>
                    <!--end::Label-->
                </label>
                <!--end::Option-->
                <!--begin::Option-->
                <div class="separator separator-dashed my-6"></div>
                <!--end::Option-->
                <!--begin::Option-->
                <label class="form-check form-check-custom form-check-solid align-items-start">
                    <!--begin::Input-->
                    <input class="form-check-input me-3" type="checkbox"
                           {{$this->isChecked('subscription_email_notification')}} onchange="@this.toggleEmailPreferencesValue('subscription_email_notification',event.target.checked)">
                    <!--end::Input-->
                    <!--begin::Label-->
                    <span class="form-check-label d-flex flex-column align-items-start">
                                                <span class="fw-bold fs-5 mb-0">دریافت اطلاعیه اشتراک</span>
                                                <span class="text-muted fs-6">دریافت ایمیل در صورت اتمام حجم یا زمان، شروع اشتراک و رزرو اشتراک</span>
                                            </span>
                    <!--end::Label-->
                </label>
                <!--end::Option-->

                <div class="overlay-layer bg-transparent w-100 d-none z-index-3"
                     style="backdrop-filter: blur(4px);"
                     wire:loading.class.remove="d-none" wire:target="toggleEmailPreferencesValue">
                    <div class="spinner-border text-primary" role="status">
                    </div>
                </div>
            </div>

        </div>
        <!--end::Card body-->
    </div>
    <!--end::Content-->
</div>
