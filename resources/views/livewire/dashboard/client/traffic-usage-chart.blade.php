<div class="col-xxl-8">
    <div wire:ignore class="card bg-body border-0 mb-5 mb-xl-0">
        <!--begin::Card header-->
        <div class="card-header d-flex justify-content-center">
            <!--begin::Card title-->
            <div class="card-title user-select-none">
                <h2 class="m-0">مصرف هفت روز گذشته</h2>
            </div>

            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div dir="ltr" class="card-body p-9 pt-4">
            @if($user->trafficUsages()->where('created_at','>',now()->addMonths(-1))->count())
                <div id="traffic_usage_chart"></div>
            @else
                <div class="d-flex flex-column justify-content-center align-content-center align-items-center">
                    <img src="{{asset('media/illustrations/sigma-1/9.png')}}" class="w-200px h-200px" alt="">
                    <div class="fw-semibold fs-3 user-select-none"> مصرفی ثبت نشده است
                    </div>
                    <a href="#connection_guide" class="btn btn-light-primary mt-3">راهنمای اتصال</a>
                </div>
            @endif

        </div>
        <!--end::Card body-->
    </div>
</div>
@push('scripts')
    <script src="{{asset('plugins/custom/lightweightchart/lightweightchart.bundle.js')}}"></script>
    @if($user->trafficUsages()->where('created_at','>',now()->addMonths(-1))->count())
        <script>
            function formatBytes(bytes, decimals = 2) {
                if (!+bytes) return '0 Bytes'

                const k = 1024
                const dm = decimals < 0 ? 0 : decimals
                const sizes = ['بایت', 'کیلوبایت', 'مگابایت', 'گیگا بایت', 'ترابایت', 'PB', 'EB', 'ZB', 'YB']

                const i = Math.floor(Math.log(bytes) / Math.log(k))

                return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`
            }

            document.addEventListener('livewire:load', function () {
                @this.
                getTrafficUsageChartData();

                var chartElement = document.createElement('div');

                new ResizeObserver(entries => {
                    if (entries.length === 0 || entries[0].target !== chartElement) {
                        return;
                    }
                    const newRect = entries[0].contentRect;
                    chart.applyOptions({height: newRect.height, width: newRect.width});
                }).observe(chartElement);

                var chartOptions = {
                    width: 702,
                    height: 351,

                    layout: {
                        backgroundColor: document.documentElement.getAttribute('data-theme') === 'dark' ? '#1e1e2d' : '#ffffff',
                        textColor: document.documentElement.getAttribute('data-theme') !== 'dark' ? '#1e1e2d' : '#ffffff',
                    },
                    localization: {
                        locale: 'fa-IR',
                        dateFormat: 'yyyy-MM-dd',
                        priceFormatter: function (cpu) {
                            return formatBytes(cpu.toFixed(0));
                        },
                    },
                    grid: {
                        vertLines: {
                            visible: true,
                            color: 'rgba(140,140,140,0.10)',
                        },
                        horzLines: {
                            visible: true,
                            color: 'rgba(140,140,140,0.10)',
                        },
                    },
                    rightPriceScale: {
                        borderVisible: false,
                    },
                    timeScale: {
                        borderColor: 'rgba(197, 203, 206, 1)',
                        borderVisible: false,
                        timeVisible: true,
                        secondsVisible: false,
                    },
                    crosshair: {
                        horzLine: {
                            visible: false,
                        },
                    },
                };


                var chart = window.lightWeightChart.createChart(chartElement, chartOptions);

                document.addEventListener('themeChanged', function () {
                    if (document.documentElement.getAttribute('data-theme') === 'dark') {
                        chartOptions.layout.background.color = "#1e1e2d";
                        chartOptions.layout.textColor = "#ffffff";
                    } else {
                        chartOptions.layout.background.color = "#ffffff";
                        chartOptions.layout.textColor = "#1e1e2d";
                    }
                    console.log(chartOptions);
                    chart.applyOptions(chartOptions)
                })

                chartElement.classList.add("d-flex");
                chartElement.classList.add("justify-content-center");

                document.getElementById('traffic_usage_chart').appendChild(chartElement);

                var areaSeries = null;
                areaSeries = chart.addAreaSeries({
                    topColor: 'rgba(26,106,207, 0.56)',
                    bottomColor: 'rgba(26,106,207, 0.04)',
                    lineColor: 'rgb(26,106,207)',
                    lineWidth: 2,
                });
                document.addEventListener('traffic-data', function (e) {
                    for (const datum of Object.entries(e.detail.chartData)) {
                        areaSeries.update({
                            'value': datum[1],
                            'time': new Date(Date.parse(datum[0].replace(/-/g, '/'))).getTime() / 1000 + {{((date('O') == "+0430") ? 4.5 : 3.5) * 3600}}
                        });
                    }
                });
            });

        </script>
    @endif
@endpush
