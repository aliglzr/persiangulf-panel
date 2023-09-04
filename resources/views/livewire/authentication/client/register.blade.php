<div xmlns:wire="http://www.w3.org/1999/xhtml">
    @if($step == 'register')
        <form class="fade-in" wire:submit.prevent="register">
            <div class="text-center mb-11">
                <h1 class="text-dark fw-bolder mb-3">ثبت نام</h1>
            </div>
            <div class="row fv-row mb-7">
                <div class="col-xl-6 mb-8 mb-lg-0">
                    <input class="form-control bg-transparent" type="text" tabindex="1"
                           wire:model.defer="user.first_name"
                           autocomplete="off" placeholder="نام"/>
                </div>
                @error('user.first_name')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div data-field="user.first_name">{{$message}}</div>
                </div>
                @enderror
                <div class="col-xl-6">
                    <input class="form-control bg-transparent" type="text" tabindex="2"
                           wire:model.defer="user.last_name"
                           autocomplete="off" placeholder="نام خانوادگی"/>
                </div>
                @error('user.last_name')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div data-field="user.last_name">{{$message}}</div>
                </div>
                @enderror

            </div>


            <div class="fv-row mb-8 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                <input type="text" placeholder="نام کاربری" wire:model.defer="user.username"
                       autocomplete="off"
                       class="form-control bg-transparent" dir="rtl" tabindex="3">
                @error('user.username')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div data-field="user.username">{{$message}}</div>
                </div>
                @enderror
                <div class="form-text">
                    نام کاربری کلمه ای حداقل ۵ حرفی که می تواند ترکیبی از حروف و اعداد انگلیسی باشد.
                </div>
            </div>


            <div class="fv-row mb-8 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">

                <input type="text" placeholder="نشانی ایمیل" wire:model.defer="user.email" autocomplete="off"
                       class="form-control bg-transparent" dir="rtl" tabindex="4">
                @error('user.email')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div data-field="user.email">{{$message}}</div>
                </div>
                @enderror
                <div class="form-text">
                    برای فعال سازی حساب شما، لینک تأیید به این ایمیل ارسال خواهد شد تا آن را تایید کنید.
                </div>

            </div>


            <div class="fv-row mb-8 fv-plugins-icon-container">


                <input class="form-control bg-transparent" type="password" placeholder="گذرواژه"
                       wire:model.defer="password" tabindex="5" autocomplete="new-password">
                @error('password')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div data-field="password">{{$message}}</div>
                </div>
                @enderror
                <div class="form-text">
                    گذرواژه باید حداقل ۶ حرف باشد و پیشنهاد می شود از حروف و کاراکتر های خاص مثل @ در آن استفاده نمایید.
                </div>
            </div>


            <div class="fv-row mb-8 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">

                <input type="text" placeholder="کد دعوت" wire:model.defer="invite_code" autocomplete="off"
                       class="form-control bg-transparent" dir="rtl" tabindex="6">
                @error('invite_code')
                <div class="fv-plugins-message-container invalid-feedback">
                    <div data-field="invite_code">{{$message}}</div>
                </div>
                @enderror
                <div class="form-text">
                    در صورتی که کاربری شما را به ما معرفی کرده است لطفاً کد دعوت ایشان را وارد کنید.
                </div>
            </div>


            <div class="d-grid mb-10">
                <button type="submit" wire:target="register" class="btn btn-primary" tabindex="7">

                <span class="indicator-label" wire:target="register" wire:loading.class="d-none">
                    ارسال ایمیل
                </span>
                    <span class="indicator-progress" wire:target="register" wire:loading.class="d-block">
                    در حال ارسال
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>

                </button>
            </div>

        </form>
    @elseif($step == 'verify-mail')
        <div class="fade-in mb-11" >
            <div class="text-center mb-11">
                <h1 class="text-dark fw-bolder mb-3">ثبت نام</h1>
            </div>

            <div class="alert alert-success mb-5 p-5" role="alert">
                <h4 class="alert-heading">ثبت نام شما با موفقیت انجام شد!</h4>
                <p>
                    به عنوان بخشی از فرآیند تأیید حساب، یک ایمیل به نشانی ایمیل شما ارسال شده است که شامل لینک تأیید می‌باشد.<br>
                    لطفاً با مراجعه به ایمیل خود و کلیک بر روی لینک تأیید، حساب خود را فعال کنید تا بتوانید از امکانات و خدمات ما بهره‌مند شوید.<br>
                </p>
                <div class="border-bottom border-success opacity-20 mb-5"></div>
                <p class="mb-0">
                    اگر هنوز ایمیل تأیید را دریافت نکرده‌اید، لطفاً فولدر اسپم یا پوشه‌ی هرزنامه (Junk/Spam) ایمیل خود را نیز بررسی کنید. در صورت بروز هرگونه مشکل یا نیاز به کمک، با تیم پشتیبانی ما تماس بگیرید.<br>
                </p>
            </div>
        </div>
    @endif
</div>


