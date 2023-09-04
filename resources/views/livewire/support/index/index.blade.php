<div>
    <livewire:support.header/>
    <div class="row gy-0 mb-6 mb-xl-12">
        <!--begin::Col-->
        <div class="col-md-4">
            <div class="d-flex flex-column">
                <!--begin::Card-->
                <div class="card me-xl-2 mb-md-6 mb-6">
                    <!--begin::Body-->
                    <div class="card-body p-10 p-lg-10">
                        <!--begin::Header-->
                        <div class="d-flex flex-column mb-3">
                            <!--begin::Title-->
                            <h1 class="fw-bold text-dark">آموزش</h1>
                            <!--end::Title-->

                            <h3 class="fw-semibold text-gray-800 mt-3 text-justify">اگر میخواهید اطلاعات خود را در رابطه
                                با سرویس های سالید وی پی ان افزایش دهید، این قسمت را ببینید.</h3>

                            <!--begin::Section-->

                        </div>
                        <!--end::Header-->
                        <a href="{{route('support.tutorials')}}"
                           class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary mt-3">مشاهده<i
                                class="fas fa-angle-left fs-4 ms-2"></i></a>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card-->
                <!--begin::Card-->
                <div class="card me-xl-2 mb-md-6 mb-6">
                    <!--begin::Body-->
                    <div class="card-body p-10 p-lg-10">
                        <!--begin::Header-->
                        <div class="d-flex flex-column mb-3">
                            <!--begin::Title-->
                            <h1 class="fw-bold text-dark">سوالات متداول</h1>
                            <!--end::Title-->

                            <h3 class="fw-semibold text-gray-800 mt-3 text-justify">قبل از ارسال تیکت اینجا را ببینید تا
                                پاسخ پرسش های خود را پیدا کنید.</h3>

                            <!--begin::Section-->

                        </div>
                        <!--end::Header-->
                        <a href="{{route('support.faq')}}"
                           class="btn btn-outline btn-outline-dashed btn-outline-primary btn-active-light-primary mt-3">مشاهده<i
                                class="fas fa-angle-left fs-4 ms-2"></i></a>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card-->
            </div>
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-8">
            <!--begin::Card-->
            <div class="card ms-xl-3">
                <!--begin::Body-->
                <div class="card-body p-10 p-lg-10">
                    <!--begin::Header-->
                    <div class="d-flex flex-stack mb-7">
                        <!--begin::Title-->
                        <h1 class="fw-bold text-dark">آخرین تیکت ها</h1>
                        <!--end::Title-->
                    @if(auth()->user()->tickets()->count())
                        <!--begin::Section-->
                            <div class="d-flex align-items-center">
                                <span class="text-dark fw-semibold">تعداد کل تیکت ها:</span>
                                <span
                                    class="text-primary m-2">{{convertNumbers(auth()->user()->tickets()->count())}}</span>
                                <span class="text-dark fw-semibold">تیکت های باز:</span>
                                <!-- TODO : set open tickets count -->
                                <span
                                    class="text-primary m-2">{{convertNumbers(auth()->user()->tickets()->where('status',3)->get()->count())}}</span>
                            </div>
                            <!--end::Section-->
                        @endif
                    </div>
                    <!--end::Header-->

                    <!--Begin::Recent Tickets Table -->
                       <livewire:support.index.recent-tickets-table />
                    @if(auth()->user()->tickets()->count())
                    <!--End::Recent Tickets Table -->
                        <div class="d-flex justify-content-end align-content-center align-items-baseline">
                            <a href="{{route('support.tickets',auth()->user())}}" class="btn btn-link btn-color-primary btn-active-color-dark"><i
                                    class="bi bi-box-arrow-up-right"></i>مشاهده بیشتر</a>
                        </div>
                    @endif
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Col-->
    </div>
</div>
@section('title')
    پشتیبانی
@endsection
@section('description')
    پشتیبانی
@endsection
