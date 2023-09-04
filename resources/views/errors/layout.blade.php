@extends('base.base')

@section('content')
    @php
        theme()->addHtmlClass('body','app-blank');
        theme()->addHtmlClass('body','bgi-size-cover');
        theme()->addHtmlClass('body','bgi-attachment-fixed');
        theme()->addHtmlClass('body','bgi-position-center');
        theme()->addHtmlClass('body','bgi-no-repeat');
    @endphp
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
        <style>
            body {
                background-image: url('{{ asset(theme()->getMediaUrlPath() . 'auth/bg7.jpg') }}');
            }

            [data-theme="dark"] body {
                background-image: url('{{ asset(theme()->getMediaUrlPath() . 'auth/bg7-dark.jpg') }}');
            }
        </style>
        <!--end::Page bg image-->
        <!--begin::Authentication - Signup Welcome Message -->
        <div class="d-flex flex-column flex-center flex-column-fluid">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center text-center p-10">
                {{ theme()->getView('layout/_content', compact('slot')) }}
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Signup Welcome Message-->
    </div>

@endsection
