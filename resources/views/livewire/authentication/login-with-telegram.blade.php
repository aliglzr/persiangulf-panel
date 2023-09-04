<div class="fade-in" xmlns:wire="http://www.w3.org/1999/xhtml">
    <style>
        [data-theme="dark"] .qrcode {
            filter: invert(1);
            opacity: 0.7;
        }
    </style>
    <!--begin::Heading-->
    <div class="text-center mb-11">
        <!--begin::Title-->
        <h1 class="text-dark fw-bolder mb-3">ورود با تلگرام</h1>
        <!--end::Title-->
    </div>
    <!--begin::Heading-->

    <div class="text-center">
        @if($step == 'waiting')
            <a rel="nofollow" target="_blank" href="{{$link}}"><img id="qrcodeImage" src="{{$qrcode}}"
                                     class="img-fluid qrcode w-200px h-200px p-4 border-2 border rounded border-dashed" alt=""></a>
            <div class="fw-semibold fs-6 my-5">لطفاً کد QR بالا را اسکن نمایید و پس از ورود به نرم افزار تلگرام دکمه Start
                را بزنید.
            </div>
            <div class="fw-semibold text-warning fs-7 my-5">لطفاً در هنگام انجام عملیات ورود در این صفحه بمانید و از بستن صفحه خودداری نمایید!</div>
            <div style="text-align: justify;">
                <div class="alert alert-primary fs-6 mb-5 p-5" role="alert">
                    <p>
                        شما همچنین می توانید با ارسال کد <span class="badge badge-primary fs-6 cursor-pointer m-1" id="login-code" style="letter-spacing: .2rem;padding-bottom: 1px;padding-top: 6px;" onclick="event.preventDefault();copyToClipboard('login-code')">{{$code}}</span> به ربات <span class="badge fs-6 badge-primary cursor-pointer m-1" style="padding-bottom: 1px;padding-top: 6px;" id="telegram-bot" onclick="event.preventDefault();copyToClipboard('telegram-bot')">{{$bot}}</span>در تلگرام عملیات ورود را تکمیل کنید.
                    </p>
                    <div class="border-bottom border-primary opacity-20 mb-5"></div>
                    <p class="mb-0">
                        لطفا در صورت بروز هرگونه مشکل یا نیاز به کمک، با تیم پشتیبانی ما تماس بگیرید.
                    </p>

                </div>
            </div>
        @elseif($step == 'logged-in')
            <div style="text-align: justify;">
                <div class="alert alert-success fs-6 mb-5 p-5" role="alert">
                    <p>
                        احراز هویت شما با موفقیت از طریق تلگرام انجام شد، پس از ۵ ثانیه به طور خودکار به پیشخان منتقل خواهید شد.
                    </p>
                    <div class="border-bottom border-success opacity-20 mb-5"></div>
                    <p class="mb-0">
                        در صورت عدم انتقال به پیشخان پس از ۵ ثانیه رو دکمه <a class="badge badge-light-primary cursor-pointer m-1" href="{{route('dashboard')}}">انتقال</a> کلیک کنید.
                    </p>

                </div>
            </div>
        @endif
    </div>



</div>

