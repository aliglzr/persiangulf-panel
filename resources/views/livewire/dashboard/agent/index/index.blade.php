<div id="kt_content_container" class="container-xxl" xmlns:wire="http://www.w3.org/1999/xhtml">
    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <div class="col-12 col-xxl-12">
            <!--begin::Mixed Widget 4-->
            <div class="card h-xl-100">
                <!--begin::Beader-->
                <div class="card-header border-0 py-5">
                    <div class="card-title h3 align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">گزارش تعداد مشتریان</span>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Tabs-->
                        <ul class="nav" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 active"
                                        data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">هفته
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button onclick="month()"
                                        class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1"
                                        data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">ماه
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1"
                                        data-bs-toggle="tab" aria-selected="true" role="tab">سال
                                </button>
                            </li>
                        </ul>
                        <!--end::Tabs-->
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body d-flex flex-column pt-0">
                    <div wire:ignore dir="ltr" class="flex-grow-1">
                        <div id="customer_chart" class="h-300px min-h-auto w-100 ps-4 pe-6"></div>
                    </div>

                    <div class="d-flex justify-content-center pt-5">
                        <div class="text-center fs-6 pb-10">
                            <div class="badge badge-light-primary fs-8">تعداد مشتریان کل</div>
                            <div class="fw-semibold text-dark">{{convertNumbers(auth()->user()->clients()->count())}}</div>
                        </div>
                        <div class="mx-5"></div>
                        <div class="text-center fs-6 pb-10">
                            <div class="badge badge-light-success fs-8">تعداد مشتریان هفته گذشته</div>
                            <div class="fw-semibold text-dark">{{convertNumbers(27)}}</div>
                        </div>
                    </div>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Mixed Widget 4-->
        </div>
    </div>
    <!--end::Row-->
</div>
@push('styles')
    <style>
        #customer_chart .apexcharts-tooltip {
            max-width: 150px !important;
            min-width: 150px !important;
        }

        #customer_chart .apexcharts-tooltip .apexcharts-tooltip-series-group.active {
            max-width: 150px !important;
            min-width: 150px !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        var element = document.getElementById("customer_chart");
        var height = parseInt(KTUtil.css(element, 'height'));
        var labelColor = KTUtil.getCssVariableValue('--kt-gray-900');
        var borderColor = KTUtil.getCssVariableValue('--kt-border-dashed-color');
        var options = {
            series: [{
                name: 'تعداد مشتریان',
                data: [54, 42, 75, 110, 23, 87, 50]
            }],
            chart: {
                fontFamily: 'YekanBakh',
                height: height,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: ['28%'],
                    borderRadius: 5,
                    dataLabels: {
                        position: "top" // top, center, bottom
                    },
                    startingShape: 'flat'
                },
            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: true,
                offsetY: -28,
                style: {
                    fontSize: '13px',
                    colors: [labelColor]
                },
                formatter: function (val) {
                    return val;// + "H";
                }
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['شنبه', 'یکشنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنج شنبه', 'جمعه'],
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: KTUtil.getCssVariableValue('--kt-gray-500'),
                        fontSize: '13px'
                    }
                },
                crosshairs: {
                    fill: {
                        gradient: {
                            opacityFrom: 0,
                            opacityTo: 0
                        }
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: KTUtil.getCssVariableValue('--kt-gray-500'),
                        fontSize: '13px'
                    },
                }
            },
            fill: {
                opacity: 1
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            tooltip: {
                enabled: true,
            },
            colors: [KTUtil.getCssVariableValue('--kt-primary'), KTUtil.getCssVariableValue('--kt-primary-light')],
            grid: {
                borderColor: borderColor,
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#customer_chart"), options);
        chart.render();

        function month() {
            chart.updateSeries([{
                name: 'تعداد مشتریان',
                data: [
                    1, 2, 3, 4, 5, 6, 7,
                    8, 9, 10, 11, 12, 13, 14,
                    15, 16, 17, 18, 19, 20, 21,
                    22, 23, 24, 25, 26, 27, 28,
                    29,30
                ]
            }]);
            chart.updateOptions({
                xaxis: {
                    categories: [
                        '1', '2', '3', '4', '5', '6', '7',
                        '8', '9', '10', '11', '12', '13', '14',
                        '15', '16', '17', '18', '19', '20', '21',
                        '22', '23', '24', '25', '26', '27', '28',
                        '29', '30'
                    ],
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: KTUtil.getCssVariableValue('--kt-gray-500'),
                            fontSize: '13px'
                        }
                    },
                    crosshairs: {
                        fill: {
                            gradient: {
                                opacityFrom: 0,
                                opacityTo: 0
                            }
                        }
                    }
                },
            })
        }


    </script>
@endpush
