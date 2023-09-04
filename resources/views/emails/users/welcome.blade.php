@extends('emails.layout.layout')

@section('email-content')
    <style>
        *{
            font-family:Tahoma,Helvetica,sans-serif !important;
        }
    </style>
    <div style="box-shadow: 0px 0px 20px -1px rgba(140,140,140,1);
-webkit-box-shadow: 0px 0px 20px -1px rgba(140,140,140,1);
-moz-box-shadow: 0px 0px 20px -1px rgba(140,140,140,1);background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
            <tbody>
            <tr>
                <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                    <!--begin:Email content-->
                    <div style="text-align:center; margin:0 15px 34px 15px">
                        <!--begin:Logo-->
                        <div style="margin-bottom: 10px">
                            <a href="{{'https://'.\App\Models\Option::get('APP_URL')}}" rel="noopener" target="_blank">
                                <img alt="Logo" src="{{'https://'.\App\Models\Option::get('APP_URL').'/'.('media/logos/logo-75.png')}}" style="height: 75px" />
                            </a>
                        </div>
                        <!--end:Logo-->
                        <!--begin:Media-->
                        <div style="margin-bottom: 15px">
                            <img alt="Logo" src="{{'https://'.\App\Models\Option::get('APP_URL').'/'.('media/email/icon-positive-vote.png')}}" style="height: 75px; width: 75px;"/>
                        </div>
                        <!--end:Media-->
                        <!--begin:Text-->
                        <div align="start" valign="start" style="font-size: 14px; font-weight: 500; ; margin:0 60px 35px 60px; font-family:Tahoma,Helvetica,sans-serif;">
                            <p style="color:#181C32; font-size: 15px; font-weight: bold; margin-bottom:13px">از اینکه مارا انتخاب کرده اید سپاسگزاریم</p>
                            <p style="margin-bottom:2px; color:#060607;line-height: 24px;text-align: justify">سالید وی پی ان در حال ساخت اینترنتی است که در آن حریم خصوصی پیش فرضی برای همه است. با استفاده از SolidVPN، شما به هزاران نفری می پیوندید که به ما کمک می کنند تا این اینترنت بهتر را به واقعیت تبدیل کنیم.

                                اکنون می توانید از حریم خصوصی آنلاین خود محافظت کنید و با استفاده از VPN ایمن بدون تبلیغات، بدون گزارش، بدون محدودیت داده و بدون محدودیت سرعت مصنوعی، به اینترنت بدون سانسور دسترسی داشته باشید.</p>

                        </div>
                        <!--end:Text-->
                    </div>
                    <!--end:Email content-->
                </td>
            </tr>
            <tr style="display: flex; justify-content: center; margin:0 60px 35px 60px">
                <td align="start" valign="start" style="padding-bottom: 10px;">
                    <p style="color:#181C32; font-size:15px;font-weight:bold; margin-bottom:13px;font-family:Tahoma,Helvetica,sans-serif;">آموزش استفاده از وی پی ان</p>
                    <!--begin::Wrapper-->
                    <div style="background: #F9F9F9; border-radius: 12px; padding:35px 30px">
                        <!--begin::Item-->
                        <div style="display:flex">
                            <!--begin::Media-->
                            <div style="display: flex; justify-content: center; align-items: center; width:40px; height:40px; margin-right:13px">
                                <span style="position: absolute; color:#009ef7; font-size: 25px; font-weight: 600;">{{convertNumbers(1)}}</span>
                            </div>
                            <!--end::Media-->
                            <!--begin::Block-->
                            <div>
                                <!--begin::Content-->
                                <div>
                                    <!--begin::Title-->
                                    <a href="#" style="margin-right: 15px;color:#181C32; font-size: 14px; font-weight: 600;font-family:Tahoma,Helvetica,sans-serif">تایید ایمیل حساب کاربری</a>
                                    <!--end::Title-->
                                    <!--begin::Desc-->
                                    <p style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px;margin-right: 15px;font-family:Tahoma,Helvetica,sans-serif">یک ایمیل جهت تایید آدرس ایمیل به {{$user->email}} ارسال شده است، ایمیل را باز کرده و با استفاده از لینک داده شده، آن را تایید کنید.</p>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Content-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed" style="margin:17px 0 15px 0"></div>
                                <!--end::Separator-->
                            </div>
                            <!--end::Block-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div style="display:flex">
                            <!--begin::Media-->
                            <div style="display: flex; justify-content: center; align-items: center; width:40px; height:40px; margin-right:13px">
                                <span style="position: absolute; color:#009ef7; font-size: 25px; font-weight: 600;">{{convertNumbers(2)}}</span>
                            </div>
                            <!--end::Media-->
                            <!--begin::Block-->
                            <div>
                                <!--begin::Content-->
                                <div>
                                    <!--begin::Title-->
                                    <a href="#" style="margin-right: 15px;color:#181C32; font-size: 14px; font-weight: 600;font-family:Tahoma,Helvetica,sans-serif">دانلود اپلیکیشن اندروید و یا دریافت کانکشن</a>
                                    <!--end::Title-->
                                    <!--begin::Desc-->
                                    <p style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px;margin-right: 15px;font-family:Tahoma,Helvetica,sans-serif">جهت استفاده از وی پی ان در سیستم عامل اندروید می توانید اپلیکیشن اندروید اختصاصی ما را دانلود کنید و برای سایر پلتفرم ها از طریق ورود به وبسایت و دریافت کانکشن متصل شوید.</p>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Block-->
                        </div>
                        <!--end::Item-->
                        <div style="text-align: center; margin-top: 20px;">
                            <!--begin:Action-->
                            <a href='{{\App\Models\Option::get('tutorial_link')}}' target="_blank" style="text-decoration: none;background-color:#009ef7; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500;font-family: Tahoma,Helvetica,sans-serif;">راهنمای اتصال</a>
                            <!--begin:Action-->
                        </div>
                        <div style="text-align: center; margin-top: 20px;">

                            <div style="font-family: Roboto,Tahoma,Helvetica,sans-serif !important;font-size: 16px;">نام کاربری: {{$user->username}}</div>
                            <div style="margin: 20px 0"></div>
                            <div style="font-family: Roboto,Tahoma,Helvetica,sans-serif !important;font-size: 16px;">گذرواژه: {{$password}}</div>
                        </div>

                        <div style="text-align: center; margin-top: 15px;">
                            <!--begin:Action-->
                            <a href='{{'https://'.\App\Models\Option::get('APP_URL').'/login'}}' target="_blank" style="text-decoration: none;font-family: Roboto,Tahoma,Helvetica,sans-serif !important;background-color:#009ef7; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500;">ورود به حساب کاربری</a>
                            <!--begin:Action-->
                        </div>

                    </div>
                    <!--end::Wrapper-->
                </td>
            </tr>
           @include('emails.layout.footer')
            </tbody>
        </table>
    </div>
@endsection
