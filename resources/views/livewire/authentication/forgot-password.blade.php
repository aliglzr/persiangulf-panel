<div xmlns:wire="http://www.w3.org/1999/xhtml">
    @if($step == 'email-input')
        <form class="fade-in" wire:submit.prevent="sendRecoveryEmail">
        <!--begin::Heading-->
            <div class="text-center mb-11">
                <!--begin::Title-->
                <h1 class="text-dark fw-bolder mb-3">بازیابی گذرواژه</h1>
                <!--end::Title-->
            </div>
            <!--begin::Heading-->

            <!--begin::Input group=-->
            <div class="fv-row mb-8 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                <!--begin::Email-->
                <input type="text" placeholder="نام کاربری یا نشانی ایمیل" wire:model.defer="email" autocomplete="off"
                       class="form-control @error('email') is-invalid @enderror bg-transparent" required autofocus
                       dir="rtl">
                <!--end::Email-->
                @error('email')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div data-field="email">{{$message}}</div>
                </div>
                @enderror

            </div>


            <!--begin::Submit button-->
            <div class="d-grid mb-8">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">

                    <!--begin::Indicator-->
                    <span class="indicator-label" wire:target="sendRecoveryEmail" wire:loading.class="d-none">
    ارسال ایمیل
</span>
                    <span class="indicator-progress" wire:target="sendRecoveryEmail" wire:loading.class="d-block">
    در حال ارسال
    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
</span>
                    <!--end::Indicator-->
                </button>
            </div>
            <!--end::Submit button-->

        </form>
        @elseif($step == 'email-sent')
            <div class="fade-in mb-11">
                <div class="text-center mb-11">
                    <h1 class="text-dark fw-bolder mb-3">بازیابی گذرواژه</h1>
                </div>

                <div class="alert alert-success mb-5 p-5" role="alert">
                    <h4 class="alert-heading">ایمیل بازیابی با موفقیت ارسال شد!</h4>
                    <p>
                        یک ایمیل حاوی لینک بازیابی گذرواژه به آدرس ایمیل شما ارسال شده است. لطفاً با مراجعه به ایمیل
                        خود، به لینک مربوطه در ایمیل دسترسی پیدا کرده و مراحل بازیابی گذرواژه را انجام دهید.
                    </p>
                    <div class="border-bottom border-success opacity-20 mb-5"></div>
                    <p class="mb-0">
                        اگر هنوز ایمیل تأیید را دریافت نکرده‌اید، لطفاً فولدر اسپم یا پوشه‌ی هرزنامه (Junk/Spam) ایمیل
                        خود را نیز بررسی کنید. در صورت بروز هرگونه مشکل یا نیاز به کمک، با تیم پشتیبانی ما تماس
                        بگیرید.<br>
                    </p>
                </div>
            </div>
        @elseif($step == 'password-changed')
            <div class="fade-in mb-11">
                <div class="text-center mb-11">
                    <h1 class="text-dark fw-bolder mb-3">بازیابی گذرواژه</h1>
                </div>

                <div class="alert alert-success mb-5 p-5" role="alert">
                    <h4 class="alert-heading">گذرواژه با موفقیت تغییر یافت!</h4>
                    <p>گذرواژه‌ی شما با موفقیت تغییر یافت. اکنون می‌توانید با استفاده از گذرواژه‌ی جدید وارد حساب کاربری خود شوید.</p>
                    <div class="border-bottom border-success opacity-20 mb-5"></div>
                    <p class="mb-0">
                        در صورت بروز هرگونه مشکل یا نیاز به کمک، با تیم پشتیبانی ما تماس
                        بگیرید.<br>
                    </p>
                </div>
            </div>
        @elseif($step == 'change-password')
            <form class="fade-in mb-11" wire:submit.prevent="changePassword">
                <div class="text-center mb-11">
                    <h1 class="text-dark fw-bolder mb-3">بازیابی گذرواژه</h1>

                    <div class="text-gray-500 fw-semibold fs-6">
                        گذرواژه جدیدی تعیین کنید:
                    </div>
                </div>
                <div class="fv-row mb-8 fv-plugins-icon-container">
                    <input class="form-control bg-transparent" type="password" placeholder="گذرواژه جدید"
                           wire:model.defer="password" tabindex="5" autocomplete="new-password">
                    @error('password')
                    <div class="fv-plugins-message-container invalid-feedback">
                        <div data-field="password">{{$message}}</div>
                    </div>
                    @enderror
                    <div class="form-text">
                        گذرواژه باید حداقل ۶ حرف باشد و پیشنهاد می شود از حروف و کاراکتر های خاص مثل @ در آن استفاده
                        نمایید.
                    </div>
                </div>
                <div class="fv-row mb-8 fv-plugins-icon-container">
                    <input class="form-control bg-transparent" type="password" placeholder="تکرار گذرواژه جدید"
                           wire:model.defer="passwordConfirm" tabindex="5" autocomplete="new-password">
                    @error('passwordConfirm')
                    <div class="fv-plugins-message-container invalid-feedback">
                        <div data-field="passwordConfirm">{{$message}}</div>
                    </div>
                    @enderror
                    <div class="form-text">
                        جهت اطمینان از به خاطر سپاری گذرواژه لطفاْ تکرار آن را وارد کنید.
                    </div>
                </div>


                <!--begin::Submit button-->
                <div class="d-grid mb-8">
                    <button type="submit" wire:target="changePassword" class="btn btn-primary">

                        <!--begin::Indicator-->
                        <span class="indicator-label" wire:target="changePassword" wire:loading.class="d-none">
                            تغییر گذرواژه
                        </span>
                        <span class="indicator-progress" wire:target="changePassword" wire:loading.class="d-block">
                            در حال تغییر
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                        <!--end::Indicator-->
                    </button>
                </div>
                <!--end::Submit button-->
            </form>
        @endif
</div>


