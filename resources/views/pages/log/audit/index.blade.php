<x-base-layout>

    <!--begin::Card-->
    <div class="card">
        <!--begin::Card body-->
        <div class="card-body pt-6">
            @include('pages.log.audit._table')
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
    @section('title')
        نمایش لاگ ها
    @endsection
    @section('description')
        نمایش لاگ ها
    @endsection
</x-base-layout>
