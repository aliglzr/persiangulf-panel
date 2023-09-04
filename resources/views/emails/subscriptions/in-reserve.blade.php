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

                    <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Tahoma,Helvetica,sans-serif;">
                        <p style="font-family:Tahoma;margin-bottom:9px; color:#181C32; font-size: 16px; font-weight:bold">اطلاعیه شروع اشتراک</p>
                        <p style="font-family:Tahoma;margin-bottom:2px; color:black">
                            کاربر گرامی؛<br>
                            اشتراک رزرو {{$subscriptionName}} {{$subscriptionDuration}} روزه
                            {{$subscriptionTraffic}} ، پس از اتمام بسته فعلی به صورت خودکار فعال خواهد شد.
                        </p>
                    </div>
                </td>
            </tr>

            @include('emails.layout.footer')
            </tbody>
        </table>
    </div>

@endsection
