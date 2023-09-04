@extends('emails.layout.layout')

@section('email-content')

    <div style="font-family:Tahoma;background-color:#ffffff; padding: 45px 0 0 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto"
               style="border-collapse:collapse; max-width: 500px;">
            <tbody>
            <tr>
                <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                    <!--begin:Email content-->
                    <div style="text-align:center; margin:0 60px 34px 60px">
                        <!--begin:Logo-->
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


                    </div>

                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Tahoma,Helvetica,sans-serif;">
                        <p style=" font-family:Tahoma,Helvetica,sans-serif;margin-bottom:9px; color:#181C32; font-size: 16px; font-weight:bold">آدرس ایمیل شما تغییر یافت</p>
                        <p style=" font-family:Tahoma,Helvetica,sans-serif;margin-bottom:2px; color:black">کاربر گرامی، ایمیل شما با موفقیت به آدرس {{$user->email}} تغییر یافت.</p>
                    </div>

                    <a href="{{$user->getProfileLink()}}"
                       target="_blank"
                       style="text-decoration:none; background-color:#009ef7; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Tahoma,Helvetica,sans-serif;">ورود به پروفایل کاربری</a>

                    <p style=" font-family:Tahoma,Helvetica,sans-serif;color:#181C32; font-size: 15px; font-weight: 500; margin-top:15px">در صورتی که دکمه بالا برای شما غیر فعال است می توانید روی لینک زیر کلیک کنید یا لینک را کپی و داخل آدرس بار مرورگرتان وارد کنید.</p>
                        <a href="{{$user->getProfileLink()}}" style="text-decoration:none; font-size: 15px; font-weight: 500; margin-bottom:15px">{{$user->getProfileLink()}}</a>
                    <!--end:Email content-->
                </td>
            </tr>

            @include('emails.layout.footer')
            </tbody>
        </table>
    </div>

@endsection