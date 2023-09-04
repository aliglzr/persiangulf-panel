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
                                <img alt="Logo"
                                     src="{{'https://'.\App\Models\Option::get('APP_URL').'/'.('media/logos/logo-75.png')}}"
                                     style="height: 75px"/>
                            </a>
                        </div>
                        <!--end:Logo-->
                        <!--begin:Media-->
                        <div style="margin-bottom: 15px">
                            <img alt="Logo"
                                 src="{{'https://'.\App\Models\Option::get('APP_URL').'/'.('media/email/icon-positive-vote-2.png')}}"
                                 style="height: 75px; width: 75px;"/>
                        </div>
                        <!--end:Media-->

                        <div style="font-size: 14px; font-weight: 500; margin-bottom: 42px; font-family:Tahoma,Helvetica,sans-serif">
                            <p style="margin-bottom:9px; color:#181C32; font-size: 16px; font-weight:bold">خرید شما با
                                موفقیت انجام شد</p>
                            <p style="margin-bottom:2px; color:#7E8299">از خرید شما متشکریم، هم اکنون می توانید به پنل
                                کاربری خود مراجعه کرده و از {{$user->isAgent() ? 'طرح' : 'اشتراک'}} خود استفاده
                                کنید.</p>

                        </div>

                    </div>
                    <!--end:Email content-->
                </td>
            </tr>
            <tr style="display: flex; justify-content: start; margin:0 60px 35px 60px">
                <td align="start" valign="start" style="padding-bottom: 10px;">
                    <div style="margin-bottom: 15px">
                        <!--begin:Title-->
                        <h3 style=" font-family:Tahoma,Helvetica,sans-serif; color:#181C32; font-size: 18px; font-weight:600; margin-bottom: 22px">
                            جزییات
                            خرید</h3>
                        <!--end:Title-->
                        <!--begin:Items-->
                        <div style="padding-bottom:9px">
                            @foreach(\App\Models\PlanUser::where('invoice_id',$invoice->id)->get() as $planUser)
                                <!--begin:Item-->
                                <div style="font-family:Tahoma,Helvetica,sans-serif; display:flex; justify-content: space-between; color:#7E8299; font-size: 17px; font-weight:500; margin-bottom:8px">

                                    @php
                                        $plan_discount = $planUser->discount_percent;
                                        $traffic = '';
                                               if(is_null($planUser->plan_traffic)){
                                                   $traffic = 'نامحدود';
                                               }else{
                                                   $traffic = convertNumbers(formatBytes($planUser->plan_traffic));
                                               }
                                    @endphp

                                            <!--begin:Description-->
                                    <div style="font-family:Arial,Helvetica,sans-serif">{{convertNumbers($planUser->plan_title)}}
                                        - {{convertNumbers($planUser->plan_users_count)}}
                                        اشتراک
                                        - {{convertNumbers($planUser->plan_duration)}}
                                        روزه
                                        {{$plan_discount ? convertNumbers(" - $plan_discount% تخفیف") : ''}}
                                        - ترافیک
                                        {{$traffic}}
                                        -
                                    </div>
                                    <!--end:Description-->
                                    <!--begin:Total-->
                                    <div style="font-family:Arial,Helvetica,sans-serif">{{convertNumbers(number_format($planUser->plan_price))}}
                                        تومان
                                    </div>
                                    <!--end:Total-->
                                </div>
                                <!--end:Item-->
                            @endforeach
                            @foreach(\App\Models\Subscription::where('invoice_id',$invoice->id)->get() as $subscription)
                                <!--begin:Item-->
                                <div style="font-family:Tahoma,Helvetica,sans-serif; display:flex; justify-content: space-between; color:#7E8299; font-size: 17px; font-weight:500; margin-bottom:8px">

                                    <!--begin:Description-->
                                    <div style="font-family:Arial,Helvetica,sans-serif">{{convertNumbers($subscription->planUser->plan_title)}}
                                        - ۵
                                        اشتراک
                                        - {{convertNumbers($subscription->duration)}}
                                        روزه
                                        - {{convertNumbers(formatBytes($subscription->total_traffic))}}
                                        -
                                    </div>
                                    <!--end:Description-->
                                    <!--begin:Total-->
                                    <div style="font-family:Arial,Helvetica,sans-serif">{{convertNumbers(number_format($subscription->planUser->plan_sell_price))}}
                                        تومان
                                    </div>
                                    <!--end:Total-->
                                </div>
                                <!--end:Item-->
                            @endforeach

                            <!--begin::Separator-->
                            <div class="separator separator-dashed" style="margin:15px 0"></div>
                            <!--end::Separator-->
                            <!--begin:Item-->
                            <div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 17px; font-weight:500">
                                <!--begin:Description-->
                                <div style="font-family:Tahoma,Helvetica,sans-serif">جمع کل</div>
                                <!--end:Description-->
                                <!--begin:Total-->
                                <div style="color:#181C32; margin-right: 5px; margin-left: 5px; font-family:Tahoma,Helvetica,sans-serif">{{convertNumbers(number_format($invoice->total_amount))}}
                                    تومان
                                </div>
                                <!--end:Total-->
                            </div>
                            <!--end:Item-->
                            <!--begin:Item-->
                            <div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 17px; font-weight:500">
                                <!--begin:Description-->
                                <div style="font-family:Tahoma,Helvetica,sans-serif">تخفیف</div>
                                <!--end:Description-->
                                <!--begin:Total-->
                                <div style="color:#181C32; margin-right: 5px; margin-left: 5px; font-family:Tahoma,Helvetica,sans-serif">{{convertNumbers(number_format($invoice->total_discount))}}
                                    تومان
                                </div>
                                <!--end:Total-->
                            </div>
                            <!--end:Item-->
                            <!--begin:Item-->
                            <div style="display:flex; justify-content: space-between; color:#7E8299; font-size: 17px; font-weight:500">
                                <!--begin:Description-->
                                <div style="font-family:Tahoma,Helvetica,sans-serif">مبلغ پرداخت شده</div>
                                <!--end:Description-->
                                <!--begin:Total-->
                                <div style="color:#181C32; margin-right: 5px; margin-left: 5px; font-family:Tahoma,Helvetica,sans-serif">{{convertNumbers(number_format($invoice->net_amount_payable))}}
                                    تومان
                                </div>
                                <!--end:Total-->
                            </div>
                            <!--end:Item-->
                        </div>
                        <!--end:Items-->
                    </div>
                    @php
                        $invoiceLink = 'https://'.\App\Models\Option::get('APP_URL').getRequestUri(route('invoices.show',$invoice));
                    @endphp

                    <div style="display: flex;justify-content: center;margin-top: 10px">
                        <!--begin:Action-->
                        <a href="{{$invoiceLink}}"
                           target="_blank"
                           style="text-decoration:none; background-color:#009ef7; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Tahoma,Helvetica,sans-serif;">مشاهده
                            جزییات</a>
                        <!--end:Action-->
                    </div>

                    <p style="color:#181C32; font-size: 15px; font-weight: 500; margin-top:15px; font-family:Tahoma,Helvetica,sans-serif;">
                        در صورتی که دکمه بالا
                        برای شما غیر فعال است می توانید از طریق لینک زیر به جزییات پرداخت دسترسی داشته باشید.</p>
                    <div style="display: flex;justify-content: end">
                        <a href="{{$invoiceLink}}"
                           style="text-decoration:none; font-size: 15px; font-weight: 500; margin-bottom:15px; font-family:Tahoma,Helvetica,sans-serif;">{{$invoiceLink}}</a>
                    </div>
                </td>
            </tr>
            @include('emails.layout.footer')
            </tbody>
        </table>
    </div>

@endsection
