@php use App\Models\User; @endphp
<div class="container-xxl" xmlns:wire="http://www.w3.org/1999/xhtml" xmlns:livewire>
    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mt-5">
        @if(!$user->hasActiveSubscription())
            <div class="col-12 overflow-auto pb-5">
                <!--begin::Notice-->
                <div
                        class="notice d-flex align-items-center bg-light-warning rounded border-warning border border-dashed min-w-lg-600px flex-shrink-0 p-6">
                    <!--begin::Icon-->
                    <!--begin::Svg Icon | path: icons/duotune/coding/cod004.svg-->
                    <i class="fa fa-triangle-exclamation fs-2tx text-warning me-4"></i>
                    <!--end::Svg Icon-->
                    <!--end::Icon-->
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                        <!--begin::Content-->
                        <div class="mb-md-0 fw-semibold">

                            <h4 class="text-warning align-bottom fw-bold m-0 user-select-none">
                                @if($user->subscriptions()->count())
                                    مشتری گرامی، اشتراک شما به پایان رسیده
                                    است.
                                @else
                                    کاربر گرامی، جهت استفاده از خدمات ما میتوانید از طریق لینک روبرو اشتراک خریداری
                                    کنید.
                                @endif
                                <span><a
                                            href="{{route('clients.buy')}}">خرید اشتراک</a></span>
                            </h4>
                        </div>
                        <!--end::Content-->
                        <!--begin::Action-->
                        <!-- TODO : implement renew subscription for client -->
                        <!--end::Action-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Notice-->
            </div>

        @endif
    </div>

    <div wire:ignore class="row g-5 g-xl-10 mb-5 mb-xl-10">

        <livewire:dashboard.client.index.get-connection :user="$user"/>

        <livewire:dashboard.client.traffic-usage-chart :user="$user"/>

        <div class="col-xxl-4">
            <!--begin::Mixed Widget 4-->
            <div class="card  ">
                <!--begin::Beader-->
                <div class="card-header py-5 d-flex justify-content-center user-select-none">
                    <h3 class="card-title align-items-start flex-column mb-0">
                        <span class="card-label fw-bold fs-3">زمان باقی مانده</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div
                        class="card-body {{ $user->subscriptions()->count() == 0 ? 'h-300px' : ''}} d-flex flex-column pt-0">
                    <div dir="rtl" wire:ignore class="flex-grow-1">
                        @if($user->subscriptions()->count())
                            <div id="remaining_duration" class="d-flex justify-content-center"
                                 data-kt-chart-color="primary"></div>
                        @else
                            <div class="d-flex flex-column flex-center">
                                <img src="" height="250px" width="250px" class="img-responsive no-subscription-img"
                                     alt="">
                                <div class="fw-semibold fs-4">اشتراکی یافت نشد</div>
                            </div>
                        @endif
                    </div>
                    @if($user->subscriptions()->count())
                        <div class="pt-5">
                            <div class="d-flex flex-column justify-content-start">
                                <div class="text-center fs-6 pb-10">
                                    <div class="badge badge-light-primary fs-8">تاریخ پایان اشتراک</div>
                                    <div>{{\App\Core\Extensions\Verta\Verta::instance($user->getCurrentSubscription()?->ends_at)->persianFormat('Y/m/d H:i:s')}}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <!--end::Body-->
            </div>
            <!--end::Mixed Widget 4-->
        </div>

        <div class="col-xxl-4">
            <!--begin::Mixed Widget 4-->
            <div class="card">
                <!--begin::Beader-->
                <div class="card-header py-5 d-flex justify-content-center user-select-none">
                    <h3 class="card-title align-items-start flex-column mb-0">
                        <span class="card-label fw-bold fs-3">حجم استفاده شده</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div
                        class="card-body {{ $user->subscriptions()->count() == 0 ? 'h-300px' : ''}} d-flex flex-column pt-0">
                    <div wire:ignore dir="ltr" class="flex-grow-1">
                        @if($user->subscriptions()->count())
                            <div id="total_usage" dir="ltr" class="d-flex justify-content-center mt-5"
                                 style="width: 100%"></div>
                        @else
                            <div class="d-flex flex-column flex-center">
                                <img src="" height="250px" width="250px" class="img-responsive no-subscription-img"
                                     alt="">
                                <div class="fw-semibold fs-4">اشتراکی یافت نشد</div>
                            </div>
                        @endif
                    </div>
                    @php
                        /** @var User $user */
                        $total = $user->trafficUsage();
                        $download = $user->trafficDownloadUsage();
                        $upload = $user->trafficUploadUsage();
                        $remainingTraffic = is_null($user->getCurrentSubscription()) ? $user->subscriptions()->whereNotNull('ends_at')->whereNotNull('starts_at')->where('using',false)->latest()->first()?->remaining_traffic : $user->getCurrentSubscription()?->remaining_traffic;
                        $totalTraffic = is_null($user->getCurrentSubscription()) ? $user->subscriptions()->whereNotNull('ends_at')->whereNotNull('starts_at')->where('using',false)->latest()->first()?->total_traffic : $user->getCurrentSubscription()?->total_traffic;
                    @endphp
                    @if($user->subscriptions()->count())
                        <div class="d-flex justify-content-center pt-10">
                            <div class="text-center fs-6 pb-10">
                                <div class="badge badge-light-primary fs-8">مصرف کل</div>
                                <div
                                        class="fw-semibold text-dark">{{convertNumbers(formatBytes($total))}}</div>
                            </div>
                            <div class="mx-5"></div>
                            <div class="text-center fs-6 pb-10">
                                <div class="badge badge-light-success fs-8">بارگیری</div>
                                <div
                                        class="fw-semibold text-dark">{{convertNumbers(formatBytes($download))}}</div>
                            </div>
                            <div class="mx-5"></div>
                            <div class="text-center fs-6 pb-10">
                                <div class="badge badge-light-info fs-8">بارگذاری</div>
                                <div
                                        class="fw-semibold text-dark">{{convertNumbers(formatBytes($upload))}}</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center pt-5">
                            @if(!is_null($remainingTraffic))
                                <div class="text-center fs-6 pb-10">
                                    <div class="badge badge-light-dark fs-8">حجم باقی مانده</div>
                                    <div
                                            class="fw-semibold text-dark">{{( $remainingTraffic < 0 ? '-' : '').convertNumbers(formatBytes(abs($remainingTraffic))) }}</div>
                                </div>
                                <div class="mx-5"></div>
                            @endif
                            <div class="text-center fs-6 pb-10">
                                <div class="badge badge-light-warning fs-8">حجم کل</div>
                                <div
                                        class="fw-semibold text-dark">{{is_null($user->getCurrentSubscription()) ? convertNumbers(formatBytes($user->subscriptions()->whereNotNull('ends_at')->whereNotNull('starts_at')->where('using',false)->latest()->first()->total_traffic)) : convertNumbers(formatBytes($totalTraffic))}}</div>
                            </div>
                        </div>
                    @endif
                </div>
                <!--end::Body-->
            </div>
            <!--end::Mixed Widget 4-->
        </div>

        <div id="connection_guide" class="col-xxl-4">
            <!--begin::List Widget 4-->
            <div class="card">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark user-select-none">راهنمای اتصال</span>
                        <span class="text-gray-800 mt-1 fw-semibold fs-7 user-select-none">کاربر گرامی، جهت اتصال به سرویس لطفا پلتفرم خود را انتخاب کنید</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-5">
                    <!--begin::Item-->
                    <div class="d-flex align-items-sm-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
													<span class="symbol-label">
														<i class="bi bi-android text-success fs-1"></i>
													</span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Section-->
                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                            <div class="flex-grow-1 me-2">
                                <span class="text-gray-800 user-select-none fs-6 fw-bold ">اندروید</span>
                                <span class="text-muted fw-semibold d-block fs-7"></span>
                            </div>
                            <a href="{{\App\Models\Option::get('android_tutorial_route') ?? '#'}}"
                               class="badge badge-light-primary fw-bold my-2">مشاهده</a>
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-sm-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
													<span class="symbol-label">
														<i class="bi bi-apple text-gray-800 fs-1"></i>
													</span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Section-->
                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                            <div class="flex-grow-1 me-2">
                                <span class="text-gray-800 user-select-none fs-6 fw-bold">آیفون
                                    (IOS)</span>
                                <span class="text-muted fw-semibold d-block fs-7"></span>
                            </div>
                            <a href="{{\App\Models\Option::get('ios_tutorial_route') ?? '#'}}"
                               class="badge badge-light-primary fw-bold my-2">مشاهده</a>
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-sm-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
													<span class="symbol-label">
														<i class="bi bi-apple text-gray-800 fs-1"></i>
													</span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Section-->
                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                            <div class="flex-grow-1 me-2">
                                <span class="text-gray-800 user-select-none fs-6 fw-bold">مک (mac
                                    OS)</span>
                                <span class="text-muted fw-semibold d-block fs-7"></span>
                            </div>
                            <a href="{{\App\Models\Option::get('mac_os_tutorial_route') ?? "#"}}"
                               class="badge badge-light-primary fw-bold my-2">مشاهده</a>
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-sm-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
													<span class="symbol-label">
														<i class="bi bi-windows text-primary fs-1"></i>
													</span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Section-->
                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                            <div class="flex-grow-1 me-2">
                                <span
                                        class="text-gray-800 user-select-none fs-6 fw-bold">ویندوز</span>
                                <span class="text-muted fw-semibold d-block fs-7"></span>
                            </div>
                            <a href="{{\App\Models\Option::get('windows_tutorial_route') ?? '#'}}"
                               class="badge badge-light-primary fw-bold my-2">مشاهده</a>
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex align-items-sm-center mb-7">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-50px me-5">
													<span class="symbol-label">
														<i class="fa-brands fa-linux fs-1" style="color: purple"></i>
													</span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Section-->
                        <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                            <div class="flex-grow-1 me-2">
                                <span
                                        class="text-gray-800 user-select-none fs-6 fw-bold">لینوکس</span>
                                <span class="text-muted fw-semibold d-block fs-7"></span>
                            </div>
                            <a href="{{\App\Models\Option::get('linux_tutorial_route') ?? '#'}}"
                               class="badge badge-light-primary fw-bold my-2">مشاهده</a>
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Item-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::List Widget 4-->
        </div>

{{--    TODO: Removed android download link banner    --}}
{{--
        <div class="col-xxl-8">
            <!--begin::Engage widget 2-->
            <div class="card bg-body border-0 mb-5 mb-xl-0">
                <!--begin::Body-->
                <div class="card-body d-flex flex-row flex-lg-row justify-content-between p-lg-15">
                    <!--begin::Info-->
                    <div
                            class="d-flex flex-column justify-content-center align-items-center align-items-lg-start me-10 text-center text-lg-start">
                        <!--begin::Title-->
                        <h3 class="fs-2hx line-height-lg mb-5 user-select-none">
                            <span class="fw-bold">دانلود اپلیکیشن اندروید</span>
                            <br>
                            <span class="fw-bold fs-3">سازگار با اندروید {{convertNumbers(5)}} به بالا</span>
                        </h3>
                        <!--end::Title-->
                        <div class="fs-4 text-bold text-primary mb-7 user-select-none">تنها یک کلیک
                            <br>تا اتصال به اینترنت بی حد و مرز
                        </div>
                        <div class="d-flex flex-column flex-center">
                            <a id="download_android"
                               href="{{\App\Models\Option::get('download_android_application_direct_route')}}"
                               class="btn btn-primary px-0 d-flex flex-center fw-bold fs-4"
                               style="width: 215px !important; height: 62px"> دانلود با لینک مستقیم</a>
                            <div class="my-3"></div>
                            <a href='{{\App\Models\Option::get('download_android_application_play_store_route')}}?utm_source=SolidVPN&utm_campaign=panel&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1'><img
                                        class="w-250px" alt='Get it on Google Play'
                                        src='https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png'/></a>
                        </div>
                    </div>
                    <!--end::Info-->
                    <!--begin::Illustration-->
                    <img src="{{asset('media/mobile-app-preview.png')}}" alt=""
                         class="mw-200px mh-350px mw-lg-350px">
                    <!--end::Illustration-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Engage widget 2-->
        </div>
--}}

    </div>

    <div class="modal fade" tabindex="-1" id="showConnectionModal">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">اطلاعات کانکشن</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body d-flex justify-content-center">
                    <img id="qrcodeImage" src="" class="img-fluid" alt="">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">بستن</button>
                    <button type="button" onclick="event.preventDefault();copyConnection()" class="btn btn-primary">
                        کپی
                    </button>
                </div>
            </div>
        </div>
    </div>

    <livewire:profile.client.overview.change-connection-id :user="$user"/>

</div>

@push('scripts')
    @php
        $remainingDays = round(($user->getCurrentSubscription()?->ends_at?->timestamp - now()->timestamp));
        $totalDays = round(($user->getCurrentSubscription()?->ends_at?->timestamp - $user->getCurrentSubscription()?->starts_at?->timestamp));
    @endphp
    @if($user->subscriptions()->count())
        <script>
            var options1 = {
                series: [{{$totalDays == 0 ? 0 : round($remainingDays / $totalDays * 100)}}],
                labels: ['{{ $user->getCurrentSubscription()?->ends_at ? convertNumbers(\Illuminate\Support\Carbon::instance($user->getCurrentSubscription()?->ends_at)->diffInDays().' روز') : 'بدون اشتراک'}}'],
                chart: {
                    width: 250,
                    height: 250,
                    type: 'radialBar',
                    offsetY: 0,
                    sparkline: {
                        enabled: true,
                    }
                },
                plotOptions: {
                    radialBar: {
                        track: {
                            background: document.documentElement.getAttribute('data-theme') !== 'dark' ? "#e7e7e7" : '#1a1a27',
                            strokeWidth: '97%',
                            margin: 0, // margin is in pixels
                        },
                    },
                    dataLabels: {
                        name: {
                            show: false,
                        },
                        value: {
                            offsetY: 0,
                            color: document.documentElement.getAttribute('data-theme') !== 'dark' ? "#000000" : '#ffffff',
                            fontSize: '22px',
                        }
                    }
                },
            };

            var chart1 = new ApexCharts(document.querySelector("#remaining_duration"), options1);
            chart1.render();
        </script>
    @endif

    @if($user->subscriptions()->count())
        <script>
            var options2 = {
                series: [
                    {{$total == 0 ? 0 : round(($download) / ($totalTraffic ?? $total ) * 100)}},
                    {{$total == 0 ? 0 : round($upload / ($totalTraffic ?? $total ) * 100)}},
                    {{$remainingTraffic == null ? 0 : round(($remainingTraffic < 0 ? 0 : $remainingTraffic) / ($totalTraffic ?? $total) * 100)}}
                ],
                colors: ['#50cd89', '#7239ea', '#868686'],
                tooltip: {
                    enabled: false,
                },
                chart: {
                    width: 250,
                    height: 250,
                    position: 'center',
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 150
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
                    },
                    type: 'donut',
                    offsetY: 0,
                    sparkline: {
                        enabled: true,
                    }
                },
                plotOptions: {
                    donut: {
                        startAngle: -180,
                        endAngle: 180,
                        track: {
                            background: document.documentElement.getAttribute('data-theme') !== 'dark' ? "#e7e7e7" : '#1a1a27',
                            strokeWidth: '97%',
                            margin: 5, // margin is in pixels
                        },
                        dataLabels: {
                            name: {
                                show: false,
                            },
                            value: {
                                offsetY: 0,
                                color: document.documentElement.getAttribute('data-theme') === 'dark' ? "#ffffff" : "#000000",
                                fontSize: '22px',
                            }
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        shadeIntensity: 0.4,
                        inverseColors: false,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 50, 53, 91]
                    },
                },
            };
            var chart2 = new ApexCharts(document.querySelector("#total_usage"), options2);
            chart2.render();
        </script>
    @endif
    <script>
        @if($user->subscriptions()->count() == 0)
        var darkImageSrc = "{{asset('media/illustrations/unitedpalms-1/13-dark.png')}}";
        var lightImageSrc = "{{asset('media/illustrations/unitedpalms-1/13.png')}}";
        var collection = document.getElementsByClassName('no-subscription-img');
        document.addEventListener('livewire:load', function () {
            collection.forEach(function (img) {
                img.setAttribute('src', document.documentElement.getAttribute('data-theme') === 'dark' ? darkImageSrc : lightImageSrc);
            });
        });
        document.addEventListener('themeChanged', function () {
            collection.forEach(function (img) {
                img.setAttribute('src', document.documentElement.getAttribute('data-theme') === 'dark' ? darkImageSrc : lightImageSrc);
            });
        });
        @else
        document.addEventListener('themeChanged', function () {
            if (document.documentElement.getAttribute('data-theme') === 'dark') {
                chart1.updateOptions({
                    plotOptions: {
                        radialBar: {
                            track: {
                                background: '#1a1a27',
                                strokeWidth: '97%',
                                margin: 5, // margin is in pixels
                            },
                        },
                        dataLabels: {
                            name: {
                                show: false,
                            },
                            value: {
                                offsetY: 0,
                                color: '#ffffff',
                                fontSize: '22px',
                            }
                        }
                    }
                });
                chart2.updateOptions({
                    plotOptions: {
                        radialBar: {
                            startAngle: -90,
                            endAngle: 90,
                            track: {
                                background: "#1a1a27",
                                strokeWidth: '97%',
                                margin: 5, // margin is in pixels
                            },
                            dataLabels: {
                                name: {
                                    show: false,
                                    offsetY: -10,
                                    label: 'مصرف کل'
                                },
                                value: {
                                    offsetY: 0,
                                    fontSize: '22px',
                                    color: '#ffffff'
                                }
                            }
                        }
                    },
                });
            } else {
                chart1.updateOptions({
                    plotOptions: {
                        radialBar: {
                            track: {
                                background: "#e7e7e7",
                                strokeWidth: '97%',
                                margin: 5, // margin is in pixels
                            },
                        },
                        dataLabels: {
                            name: {
                                show: false,
                            },
                            value: {
                                offsetY: 0,
                                color: '#000000',
                                fontSize: '22px',
                            }
                        }
                    },
                });
                chart2.updateOptions({
                    plotOptions: {
                        radialBar: {
                            startAngle: -90,
                            endAngle: 90,
                            track: {
                                background: "#e7e7e7",
                                strokeWidth: '97%',
                                margin: 5, // margin is in pixels
                            },
                            dataLabels: {
                                name: {
                                    show: false,
                                    offsetY: -10,
                                    label: 'مصرف کل'
                                },
                                value: {
                                    offsetY: 0,
                                    fontSize: '22px',
                                    color: '#000000'
                                }
                            }
                        }
                    },
                });
            }
        })
        @endif

    </script>

@endpush
@section('title')
    پیشخان
@endsection
@section('description')
    پیشخان پنل کاربری جهت مشاهده گزارشات مصرف و دریافت کانکشن
@endsection
