@extends('emails.layout.layout')

@section('email-content')

    <div style="font-family:Tahoma;background-color:#ffffff; padding: 45px 0 0 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto"
               style="max-width: 500px; border-collapse:collapse">
            <tbody>
            <tr>
                <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                    <!--begin:Email content-->
                    <div style="text-align:center; margin:0 60px 34px 60px">
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

                        <!--begin:Text-->
                        <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Tahoma,Helvetica,sans-serif;">
                            <p style="margin-top:15px; color:#1a1414">کاربر گرامی؛<br>
                                پرداخت شما در {{\App\Core\Extensions\Verta\Verta::instance()->persianFormat('j F Y ساعت H:i')}} با موفقیت انجام شد و حساب کاربری‌ شما به مبلغ
                                {{convertNumbers(number_format($transaction->amount))}} تومان افزایش یافت.</p>

                        </div>
                        <!--end:Text-->


                    </div>
                    <!--end:Email content-->
                </td>
            </tr>
            <tr style="display: flex; justify-content: start; margin:0 60px 35px 60px">
                <td align="start" valign="start" style="padding-bottom: 10px;">
                    <p style="color:#181C32; font-size: 18px; font-weight: 600; margin-bottom:13px">جزییات تراکنش</p>
                    <!--begin::Wrapper-->
                    <div style="background: #F9F9F9; border-radius: 12px; padding:35px 30px;max-width: 600px;">
                        <!--begin::Item-->
                        <div style="display:flex">
                            <!--begin::Block-->
                            <div>
                                <!--begin::Content-->
                                <div>
                                    <!--begin::Title-->
                                    <p style="color:#181C32; font-size: 14px; font-weight: 600;font-family:Tahoma,Helvetica,sans-serif">
                                        موجودی قبل از تراکنش</p>
                                    <!--end::Title-->
                                    <!--begin::Desc-->
                                    <p style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Tahoma,Helvetica,sans-serif">{{convertNumbers(number_format($transaction->balance_before_transaction))}}
                                        تومان </p>
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
                                    <p style="color:#181C32; font-size: 14px; font-weight: 600;font-family:Tahoma,Helvetica,sans-serif">
                                        موجودی پس از تراکنش: </p>
                                    <!--end::Title-->
                                    <!--begin::Desc-->
                                    <a href="#"
                                       style="font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Tahoma,Helvetica,sans-serif">{{convertNumbers(number_format($transaction->balance_after_transaction))}}
                                        تومان </a>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Content-->
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
                                    <p style="color:#181C32; font-size: 14px; font-weight: 600;font-family:Tahoma,Helvetica,sans-serif">
                                        تاریخ افزایش اعتبار:</p>
                                    <!--end::Title-->
                                    <!--begin::Desc-->
                                    <p style="font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Tahoma,Helvetica,sans-serif">{{\App\Core\Extensions\Verta\Verta::instance($payment->transaction->updated_at)->persianFormat('j F Y ساعت H:i')}}</p>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Block-->
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Wrapper-->


                    @php
                        $transactionLink = 'https://'.\App\Models\Option::get('APP_URL').getRequestUri(route('payments.show', $payment));
                    @endphp

                    <div style="display: flex;justify-content: center;margin-top: 10px">
                        <!--begin:Action-->
                        <a href="{{$transactionLink}}"
                           target="_blank"
                           style="text-decoration: none; background-color:#009ef7; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Tahoma,Helvetica,sans-serif;">مشاهده
                            تراکنش</a>
                        <!--end:Action-->
                    </div>

                    <p style="font-family:Tahoma,Helvetica,sans-serif;color:#181C32; font-size: 15px; font-weight: 500; margin-top:15px">در صورتی که دکمه بالا برای شما غیر فعال است می توانید از طریق لینک زیر به جزییات تراکنش دسترسی داشته باشید.</p>
                    <div style="display: flex;justify-content: end">
                        <a href="{{$transactionLink}}" style="text-decoration: none; font-size: 15px; font-weight: 500; margin-bottom:15px">{{$transactionLink}}</a>
                    </div>
                </td>
            </tr>
            @include('emails.layout.footer')
            </tbody>
        </table>
    </div>

@endsection
