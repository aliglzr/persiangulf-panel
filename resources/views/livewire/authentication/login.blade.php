<div xmlns:wire="http://www.w3.org/1999/xhtml" xmlns:livewire>
    <style>
        .fade-in {
            opacity: 1;
            animation: fade 1s linear;
        }

        @keyframes fade {
            0%, 100% {
                opacity: 0
            }
            100% {
                opacity: 1
            }
        }
    </style>
    <form class="fade-in" wire:key="{{\Illuminate\Support\Str::random(11)}}" wire:submit.prevent="login">
        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">ورود به کنترل پنل</h1>
            <!--end::Title-->
        </div>
        <!--begin::Heading-->

        <!--begin::Input group=-->
        <div class="fv-row mb-8" dir="rtl">
            <!--begin::Email-->
            <input type="text" placeholder="نام کاربری" wire:model.defer="username"
                   autocomplete="off"
                   class="form-control bg-transparent" required autofocus tabindex="1">
            <!--end::Email-->
            @error('username')
            <div class="fv-plugins-message-container invalid-feedback">
                <div data-field="username">{{$message}}</div>
            </div>
            @enderror
        </div>
        <!--end::Input group=-->
        <div class="fv-row mb-8" dir="rtl">
            <!--begin::Password-->
            <input type="password" placeholder="گذرواژه" wire:model.defer="password" autocomplete="off"
                   class="form-control bg-transparent" tabindex="2">
            <!--end::Password-->
            @error('password')
            <div class="fv-plugins-message-container invalid-feedback">
                <div data-field="password">{{$message}}</div>
            </div>
            @enderror
        </div>
        <!--end::Input group=-->

        <!--begin::Submit button-->
        <div class="d-grid">
            <button wire:target="login" type="submit" class="btn btn-primary" tabindex="3">
                <!--begin::Indicator-->
                <span class="indicator-label" wire:target="login" wire:loading.class="d-none">
                            ورود
                        </span>
                <span class="indicator-progress" wire:target="login" wire:loading.class="d-block">
                        در حال ورود
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                <!--end::Indicator-->
            </button>
        </div>
        <!--end::Submit button-->
    </form>


</div>
@section('title')
    ورود
@endsection
@section('description')
    ورود به کنترل پنل
@endsection

