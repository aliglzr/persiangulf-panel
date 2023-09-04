<!DOCTYPE html>
<html lang="fa" dir="rtl">
<!--begin::Head-->
<head>
    <base href="../../"/>
    <title>SolidVPN Mails</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:locale" content="fa_IR"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="https://solidvpn.org"/>
    <meta property="og:site_name" content="SolidVPN"/>
    <link rel="canonical" href="https://solidvpn.org"/>
    <link rel="shortcut icon" href="{{asset('media/logos/favicon.ico')}}"/>
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{asset('plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/style.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->
<body class="app-blank app-blank" dir="rtl">
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
    <!--begin::Wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Body-->
        <div class="scroll-y flex-column-fluid px-10 py-10"
             style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
            <!--begin::Email template-->
            <style>html, body {
                    padding: 0;
                    margin: 0;
                    font-family: Tahoma, Helvetica, "sans-serif";
                }

                a:hover {
                    color: #009ef7;
                }</style>
            <div
                 style="background-color:#D5D9E2; font-family:Tahoma,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding: 12px 0 12px 0;width:100%;">

                @yield('email-content')

            </div>
            <!--end::Email template-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Root-->
<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
