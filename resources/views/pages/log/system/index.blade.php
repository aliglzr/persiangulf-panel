<x-base-layout>

    <!--begin::Card-->
    <div class="card">
        <!--begin::Card body-->
        <div class="card-body pt-6">
            @include('pages.log.system._table')
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
    @section('title')
        نمایش لاگ های سیستم
    @endsection
    @section('description')
        نمایش لاگ های سیستم
    @endsection
</x-base-layout>
