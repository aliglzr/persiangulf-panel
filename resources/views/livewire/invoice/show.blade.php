<div class="card">
    <div class="card-header border-0 px-lg-20 pt-lg-5">
        <div class="card-title">
            <!--begin::Top-->
            <div class="">
                <!--begin::Logo-->
                <div class="d-flex flex-column align-items-center align-content-center">
                    <img alt="Logo" src="{{asset('media/logos/logo.svg')}}" width="64" height="64">
                    <br>
                    <h1 class="fw-bold text-dark">Solid<span style="color: #3d5aff">VPN</span></h1>
                </div>
                <!--end::Logo-->
            </div>
            <!--end::Top-->
        </div>
        <div class="card-toolbar">
            <a href="{{URL::previous()}}" class="btn btn-secondary">بازگشت</a>
        </div>
    </div>
    <!--begin::Body-->
    <div class="card-body p-lg-20">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-xl-row">
            <!--begin::Content-->
            <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
                <!--begin::Invoice 2 content-->
                <div class="mt-n1">
                    <!--begin::Wrapper-->
                    <div class="m-0">
                        <!--begin::Row-->
                        <div class="row g-5 mb-12">
                            <!--end::Col-->
                            <div class="col-sm-3">
                                <!--end::Label-->
                                <div class="fw-semibold fs-7 text-gray-600 mb-1">شماره صورت‌حساب</div>
                                <!--end::Label-->
                                <!--end::Text-->
                                <div class="fw-bold fs-6 text-gray-800">{{convertNumbers($invoice->id)}}</div>
                                <!--end::Text-->
                            </div>

                            <div class="col-sm-3">
                                <!--end::Label-->
                                <div class="fw-semibold fs-7 text-gray-600 mb-1">نام کاربری</div>
                                <!--end::Label-->
                                <!--end::Text-->
                                <div class="fw-bold fs-6 text-gray-800">{{$invoice->user->username}}</div>
                                <!--end::Text-->
                            </div>
                            <!--end::Col-->
                            <div class="col-sm-3">
                                <!--end::Label-->
                                <div class="fw-semibold fs-7 text-gray-600 mb-1">تاریخ خرید</div>
                                <!--end::Label-->
                                <!--end::Col-->
                                <div class="fw-bold fs-6 text-gray-800">{{convertNumbers(Verta::instance($invoice->created_at)->format('H:i:s Y/m/d'))}}</div>
                                <!--end::Col-->
                            </div>
                        </div>
                        <!--end::Row-->
                        <!--begin::Content-->
                        <div class="flex-grow-1">
                            <!--begin::Table-->
                            <div class="table-responsive border-bottom mb-9">
                                <table class="table mb-3">
                                    <thead>
                                    <tr class="border-bottom fs-6 fw-bold text-muted">
                                        <th class="min-w-175px pb-2">{{$invoice->user->isAgent() ? 'نام طرح' : 'نام اشتراک'}}</th>
                                        @if($invoice->user->isAgent())
                                        <th class="min-w-70px text-end pb-2">تعداد کاربر</th>
                                        @endif
                                        <th class="min-w-80px text-end pb-2">مدت زمان</th>
                                        <th class="min-w-80px text-end pb-2">ترافیک</th>
                                        @if($invoice->user->isAgent())
                                        <th class="min-w-100px text-end pb-2">قیمت</th>
                                        <th class="min-w-100px text-end pb-2">تخفیف</th>
                                        @endif
                                        <th class="min-w-100px text-end pb-2">قیمت نهایی</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($invoice->user->isAgent())
                                    @foreach(\App\Models\PlanUser::where('invoice_id',$invoice->id)->get() as $planUser)
                                        <tr class="fw-bold text-gray-700 fs-5 text-end">
                                            <td class="d-flex align-items-center pt-6">{{convertNumbers($planUser->plan_title)}}</td>
                                            @if(!$invoice->user->isClient())
                                            <td class="pt-6">{{convertNumbers($planUser->plan_users_count)}}</td>
                                            @endif
                                            <td class="pt-6">{{convertNumbers($planUser->plan_duration).' روز '}}</td>
                                            <td class="pt-6">
                                                @if(is_null($planUser->plan_traffic))
                                                    نامحدود
                                                @else
                                                    {{convertNumbers(formatBytes($planUser->plan_traffic))}}
                                                @endif
                                            </td>
                                            <td class="pt-6 text-dark fw-bolder">{{convertNumbers(number_format($planUser->plan_price))}}
                                                {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3') !!}
                                            </td>
                                            <td class="pt-6 text-dark fw-bolder">{{convertNumbers(number_format($planUser->discount_price))}}
                                                {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3') !!}
                                            </td>
                                            <td class="pt-6 text-dark fw-bolder">{{convertNumbers(number_format($planUser->price_after_discount))}}
                                                {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3') !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        @php
                                        $subscription = \App\Models\Subscription::where('invoice_id',$invoice->id)->first();
                                        @endphp
                                        <tr class="fw-bold text-gray-700 fs-5 text-end">
                                            <td class="d-flex align-items-center pt-6">{{convertNumbers($subscription->planUser?->plan_title)}}</td>
                                            <td class="pt-6">{{convertNumbers($subscription->duration).' روز '}}</td>
                                            <td class="pt-6">
                                                @if(is_null($subscription->planUser?->plan_traffic))
                                                    نامحدود
                                                @else
                                                    {{convertNumbers(formatBytes($subscription->planUser?->plan_traffic))}}
                                                @endif
                                            </td>
                                            <td class="pt-6 text-dark fw-bolder">{{convertNumbers(number_format($invoice->total_amount))}}
                                                {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3') !!}
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <!--end::Table-->
                            <!--begin::Container-->
                            <div class="d-flex justify-content-end">
                                <!--begin::Section-->
                                <div class="mw-300px">
                                    @if($invoice->user->isAgent())
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack mb-3">
                                        <!--begin::Accountname-->
                                        <div class="fw-semibold pe-10 text-gray-600 fs-7">جمع کل:</div>
                                        <!--end::Accountname-->
                                        <!--begin::Label-->
                                        <div class="text-end fw-bold fs-6 text-gray-800">{{convertNumbers(number_format($invoice->total_amount))}}
                                            {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3') !!}
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack mb-3">
                                        @php
                                            $percent = $invoice->total_amount == 0 ? 0 : round(($invoice->total_discount / $invoice->total_amount) * 100);
                                            $title = "%$percent";
                                            $title = convertNumbers($title);
                                            $title = "<span class='badge badge-light-primary ms-2'> $title </span>";
                                        @endphp
                                                <!--begin::Accountname-->
                                        <div class="fw-semibold pe-10 text-gray-600 fs-7" dir="rtl">
                                            تخفیف{!! $title !!}</div>
                                        <!--end::Accountname-->
                                        <!--begin::Label-->
                                        <div class="text-end fw-bold fs-6 text-gray-800">{{convertNumbers(number_format($invoice->total_discount))}}
                                            {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3') !!}
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                    @endif
                                    <!--begin::Item-->
                                    <div class="d-flex flex-stack">
                                        <!--begin::Code-->
                                        <div class="fw-semibold pe-10 text-gray-600 fs-7">مبلغ پرداخت شده</div>
                                        <!--end::Code-->
                                        <!--begin::Label-->
                                        <div class="text-end fw-bold fs-6 text-gray-800">{{convertNumbers(number_format($invoice->net_amount_payable))}}
                                            {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3') !!}
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <!--end::Section-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Invoice 2 content-->
            </div>
            <!--end::Content-->

        </div>
        <!--end::Layout-->
    </div>
    <!--end::Body-->
</div>
@section('title')
    مشاهده صورتحساب
@endsection
@section('description')
    مشاهده صورتحساب
@endsection
