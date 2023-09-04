@extends('base.base')

@section('content')
    @php
        theme()->addHtmlClass('body','app-blank');
        theme()->addHtmlClass('body','bgi-size-cover');
        theme()->addHtmlClass('body','bgi-attachment-fixed');
        theme()->addHtmlClass('body','bgi-position-center');
        theme()->addHtmlClass('body','bgi-no-repeat');
    @endphp
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
        <style>
            body {
                background-image: url('{{ asset(theme()->getMediaUrlPath() . 'auth/bg4.jpg') }}');
            }

            [data-theme="dark"] body {
                background-image: url('{{ asset(theme()->getMediaUrlPath() . 'auth/bg4-dark.jpg') }}');
            }

            .bg-login-back {
                background-color: rgb(255, 255, 255);
            }

            [data-theme="dark"] .bg-login-back {
                background-color: rgba(0, 0, 0, 0.3);
            }
        </style>
        <!--end::Page bg image-->

        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-center flex-column-fluid flex-lg-row-reverse">
            <!--begin::Body-->
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center p-12 p-lg-20">
                <!--begin::Card-->
                <div class="d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-10 bg-login-back"
                     style="backdrop-filter: blur(30px)">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">

                        <!--begin::Form-->
                        <div class="form w-100" novalidate="novalidate">
                            {{ $slot }}
                        </div>
                        <!--end::Form-->

                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
@endsection
