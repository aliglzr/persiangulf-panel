<x-auth-layout>
    <!--begin::Signup Form-->
    <form class="form w-100 " novalidate="novalidate" id="kt_sign_up_form" action="{{route('password.update')}}" method="POST">
    @method('POST')
    @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $token }}">

        <input type="hidden" name="email" value="{{ $email }}">

        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">بروزرسانی رمز عبور</h1>
            <!--end::Title-->
            <!--begin::Subtitle-->
            <div class="text-gray-500 fw-semibold fs-6">جهت تغییر رمز عبور، لطفا رمز عبور و تکرار آن را وارد نمایید</div>
            <!--end::Subtitle=-->

            @error('email')
            <!--begin::Subtitle-->
            <div class="text-danger fw-semibold fs-6 mt-3">{{$message}}</div>
            <!--end::Subtitle=-->
            @enderror
        </div>
        <!--begin::Heading-->

        <!--begin::Input group-->
        <div class="fv-row mb-8 fv-plugins-icon-container" data-kt-password-meter="true">
            <!--begin::Wrapper-->
            <div class="mb-1">
                <!--begin::Input wrapper-->
                <div class="position-relative mb-3">
                    <input class="form-control @error('password') is-invalid @enderror bg-transparent" type="password" dir="rtl" placeholder="رمز عبور" name="password" autocomplete="off">
                    @error('password')
                    <div class="invalid-feedback" role="alert">
                        {{$message}}
                    </div>
                    @enderror
                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                        <i class="bi bi-eye-slash fs-2"></i>
                        <i class="bi bi-eye fs-2 d-none"></i>
                    </span>
                </div>
                <!--end::Input wrapper-->
                <!--begin::Meter-->
                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2 active"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                </div>
                <!--end::Meter-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Hint-->
            <div class="text-muted">رمز عبور باید شامل حداقل یک حرف بزرگ و یک عدد و حداقل {{convertNumbers(8)}} کاراکتر باشد</div>
            <!--end::Hint-->
        </div>
        <!--end::Input group=-->
        <!--end::Input group=-->
        <div class="fv-row mb-8 fv-plugins-icon-container">
            <!--begin::Repeat Password-->
            <input placeholder="تکرار رمز عبور" name="password_confirmation" type="password" autocomplete="off" dir="rtl" class="form-control @error('password_confirmation') is-invalid @enderror bg-transparent">
            @error('password_confirmation')
            <div class="invalid-feedback" role="alert">
                {{$message}}
            </div>
            @enderror
            <!--end::Repeat Password-->
        </div>
        <!--end::Input group=-->
        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                @include('partials.general._button-indicator',['label' => 'بروزرسانی رمز عبور','message' => 'در حال بروزرسانی'])
            </button>
        </div>
        <!--end::Submit button-->
        <div></div>
    </form>
    <!--end::Signup Form-->


    @section('title')
        بروزرسانی رمز عبور
    @endsection
    @section('description')
        بروزرسانی رمز عبور
    @endsection

</x-auth-layout>
