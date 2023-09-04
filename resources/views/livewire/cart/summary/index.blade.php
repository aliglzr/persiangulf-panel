<div>

    <!--begin::Header-->
    <div class="row g-5 g-xl-10 mb-4 mb-xl-6 mb-xl-10">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-0">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="w-100 d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-1 flex-column justify-content-center my-0">
                        جزییات پرداخت</h1>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->

            </div>
            <!--end::Toolbar container-->
        </div>
    </div>
    <!--end::Header-->

    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Content-->
        <div class="flex-lg-row-fluid me-lg-15 mb-10 mb-lg-0">
            <!--begin::Form-->
            <form class="form">
                    <livewire:cart.summary.cart-table/>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
            <livewire:cart.summary.sidebar/>
        <!--end::Sidebar-->
    </div>

</div>

@push('scripts')
@endpush
@section('title')
    سبد خرید
@endsection
@section('description')
    سبد خرید
@endsection
