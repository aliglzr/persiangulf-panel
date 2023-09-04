@extends('emails.layout.layout')

@section('email-content')

    <div style="font-family:Tahoma;background-color:#ffffff; padding: 45px 0 0 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto"
               style="max-width: 500px;border-collapse:collapse">
            <tbody>
            <tr>
                <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                    <!--begin:Email content-->
                    <div style="text-align:center; margin:0 60px 34px 60px">
                        <style>
                            .logo-height{
                                width: 11rem !important;
                                height: 4rem !important;
                            }
                        </style>
                        <!--begin:Logo-->
                        <div style="margin-bottom: 10px">
                            <a href="{{'https://'.\App\Models\Option::get('APP_URL')}}" rel="noopener" target="_blank">
                                <img alt="Logo" src="{{'https://'.\App\Models\Option::get('APP_URL').'/'.('media/logos/logo-75.png')}}" style="height: 75px" />
                            </a>
                        </div>
                        <!--end:Logo-->
                        <!--begin:Media-->
                        <div style="margin-bottom: 15px">
                            <img alt="Logo" src="{{'https://'.\App\Models\Option::get('APP_URL').'/'.('media/email/icon-positive-vote-2.png')}}" style="height: 75px; width: 75px;"/>
                        </div>
                        <!--end:Media-->
                        <!--begin:Text-->
                        <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Tahoma,Helvetica,sans-serif;">
                            {{--                            <p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">It’s almost set!</p>--}}
                            <p style="margin-bottom:2px; color:#1a1414">تیکت شما به شماره {{$ticket_id}} پاسخ داده شد</p>
                        </div>
                        <!--end:Text-->


                    </div>
                    <!--end:Email content-->
                </td>
            </tr>
            <tr style="display: flex; justify-content: start; margin:0 60px 35px 60px">
                <td align="start" valign="start" style="padding-bottom: 10px;">
                    <p style="color:#181C32; font-size: 18px; font-weight: 600; margin-bottom:13px">جزییات تیکت</p>
                    <!--begin::Wrapper-->
                    <div style="background: #F9F9F9; border-radius: 12px; padding:35px 30px;max-width: 600px;">
                        <!--begin::Item-->
                        <div style="display:flex">
                            <!--begin::Block-->
                            <div>
                                <!--begin::Content-->
                                <div>
                                    <!--begin::Title-->
                                    <p
                                       style="color:#181C32; font-size: 14px; font-weight: 600;font-family:Tahoma,Helvetica,sans-serif">عنوان: {{$title}}</p>
                                    <!--end::Title-->
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
                            <!--begin::Block-->
                            <div>
                                <!--begin::Content-->
                                <div>
                                    <!--begin::Title-->
                                    <p
                                       style="color:#181C32; font-size: 14px; font-weight: 600;font-family:Tahoma,Helvetica,sans-serif">متن پیام:</a>
                                    <!--end::Title-->
                                    <!--begin::Desc-->
                                    <p style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Tahoma,Helvetica,sans-serif">
                                        {!! $reply !!}</p>
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
                            <!--begin::Block-->
                            <div>
                                <!--begin::Content-->
                                <div>
                                    <!--begin::Title-->
                                    <p
                                       style="color:#181C32; font-size: 14px; font-weight: 600;font-family:Tahoma,Helvetica,sans-serif">واحد
                                        پاسخگو: {{$category}}</p>
                                    <!--end::Title-->
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Block-->
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Wrapper-->

                    <div style="display: flex;justify-content: center;margin-top: 10px">
                        <!--begin:Action-->
                        <a href="{{'https://'.\App\Models\Option::get('APP_URL').getRequestUri(route('support.show',$ticket_id))}}"
                           target="_blank"
                           style="text-decoration:none;background-color:#009ef7; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Tahoma,Helvetica,sans-serif;">مشاهده
                            تیکت</a>
                        <!--end:Action-->
                    </div>

                    <p style="color:#181C32; font-size: 15px; font-weight: 500; margin-top:15px">در صورتی که دکمه بالا برای شما غیر فعال است می توانید از طریق لینک زیر به تیکت خود دسترسی داشته باشید.</p>
                    <div style="display: flex;justify-content: end">
                        <a href="{{'https://'.\App\Models\Option::get('APP_URL').getRequestUri(route('support.show',$ticket_id))}}" style="font-family:Tahoma,Helvetica,sans-serif;text-decoration:none;font-size: 15px; font-weight: 500; margin-bottom:15px">{{'https://'.\App\Models\Option::get('APP_URL').getRequestUri(route('support.show',$ticket_id))}}</a>
                    </div>
                </td>
            </tr>
         @include('emails.layout.footer')
            </tbody>
        </table>
    </div>

@endsection