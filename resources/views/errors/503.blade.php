<x-error-layout>

    <!--begin::Wrapper-->
    <div class="card card-flush w-lg-650px py-5">
        <div class="card-body py-15 py-lg-20">
            <!--begin::Title-->
            <h1 class="fw-bolder fs-2qx text-gray-900 mb-4">در حال بروزرسانی</h1>
            <!--end::Title-->
            <!--begin::Illustration-->
            <div class="mb-11">

                <!--begin::Text-->
                <div class="fw-semibold fs-6 text-gray-700 mb-7">
                    با عرض پوزش، در حال حاضر سالید وی پی ان در حال بروزرسانی زیرساخت است و به زودی با نسخه به‌روز شده خود باز خواهد گشت.
                    <br>
                    این بروزرسانی به منظور بهبود عملکرد و افزودن ویژگی‌های جدید صورت می‌گیرد و هیچ تأثیری در وضعیت و کیفیت سرویس ها نخواهد داشت.
                    <br>
                    با تشکر از صبر و شکیبایی شما.
                </div>
                <!--end::Text-->
            </div>
            <!--end::Illustration-->
            <!--begin::Link-->
            <div class="mb-0">
                <a href="https://{{str_replace('panel.', '', request()->getHttpHost())}}" class="btn btn-sm btn-primary">بازگشت به سایت</a>
            </div>
            <!--end::Link-->
        </div>
    </div>
    <!--end::Wrapper-->

</x-error-layout>
@section('title')
    در حال به روزرسانی
@endsection
@section('description')
    با عرض پوزش، در حال حاضر سالید وی پی ان در حال بروزرسانی زیرساخت است و به زودی با نسخه به‌روز شده خود باز خواهد گشت.
@endsection
