@extends('emails.layout.layout')

@section('email-content')

    <div style="font-family:Tahoma;background-color:#ffffff; padding: 45px 0 0 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto"
               style="max-width: 500px;border-collapse:collapse">
            <tbody>
            <tr>
                <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                    <!--begin:Email content-->
                    <div style="text-align:center; margin:0 60px 34px 60px;max-width: 500px;">
                        <!--begin:Logo-->
                        <div style="margin-bottom: 10px">
                            <a href="{{'https://'.\App\Models\Option::get('APP_URL')}}" rel="noopener" target="_blank">
                                <img alt="Logo" src="{{'https://'.\App\Models\Option::get('APP_URL').'/'.('media/logos/logo-75.png')}}" style="height: 75px" />
                            </a>
                        </div>
                        <!--end:Logo-->
                        <style>
                            .logo-height {
                                width: 11rem !important;
                                height: 4rem !important;
                            }

                            .image-size {
                                width: 13rem !important;
                                height: 13rem !important;
                            }
                        </style>
                        <!--begin:Media-->
                        <div style="margin-bottom: 15px">
                            <img alt="Logo" src="{{'https://'.\App\Models\Option::get('APP_URL').'/'.('media/email/icon-positive-vote-2.png')}}" style="height: 75px; width: 75px;"/>
                        </div>
                        <!--end:Media-->


                    </div>

                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                        <p style="font-family:Tahoma;margin-bottom:9px; color:#181C32; font-size: 16px; font-weight:bold">بازیابی گذرواژه حساب کاربری</p>
                        <p style="font-family:Tahoma;margin-bottom:2px; color:black">
                            کاربر گرامی درخواست گذرواژه جدید برای حساب کاربری شما داده شده است؛<br>
                            اگر این درخواست از طرف شما نبوده است، این ایمیل را نادیده بگیرید<br> اما اگر مایل به ادامه ‌دادن هستید می توانید با کلیک بر روی دکمه زیر عملیات تغییر گذرواژه خود را ادامه دهید ...
                        </p>
                    </div>

                    @php
                    $route = 'https://'.\App\Models\Option::get('APP_URL').'/auth?email='.urlencode($user->email).'&token='.urlencode($token);
                    @endphp

                    <a href="{{$route}}"
                       target="_blank"
                       style="font-family:Tahoma;background-color:#009ef7; text-decoration:none; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500;">تغییر گذرواژه</a>

                    <p style="font-family:Tahoma;color:#181C32; font-size: 15px; font-weight: 500; margin-top:15px">در صورتی که دکمه بالا برای شما غیر فعال است می توانید روی لینک زیر کلیک کنید.</p>
                        <a href="{{$route}}" style="text-decoration:none; font-size: 15px; max-width: 400px; font-weight: 500; margin-bottom:15px">{{$route}}</a>
                    <!--end:Email content-->
                </td>
            </tr>

            @include('emails.layout.footer')
            </tbody>
        </table>
    </div>

@endsection
