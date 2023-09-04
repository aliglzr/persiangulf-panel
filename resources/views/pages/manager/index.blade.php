<x-base-layout>
    @section('title')
        مدیران
    @endsection
    @section('description')
        نمایش لیست مدیران
    @endsection

    <!--begin::Card-->
    <div class="card">
        <!--begin::Card body-->
        <div class="card-body pt-6">
            @include('pages.manager._table')
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</x-base-layout>
