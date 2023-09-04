<x-base-layout>

    @section('actions')
        @can('create-discount')
        <div class="d-flex align-items-center py-1">
            <!--begin::Wrapper-->
            <div>
                <a href="#" class="btn btn-sm btn-primary fw-bolder" data-bs-toggle="modal"
                   data-bs-target="#createDiscountModal" id="createDiscountButton">
                    <span style="margin-left: 0.5rem">افزودن کد تخفیف</span>
                    {!! theme()->getSvgIcon("icons/duotune/general/gen035.svg", "svg-icon svg-icon-1 m-0") !!}
                </a>
            </div>
            <!--end::Wrapper-->
        </div>
        @endcan

    @endsection

<!--begin::Card-->
    <div class="card">
        <!--begin::Card body-->
        <div class="card-body pt-6">
            @include('pages.discount._table')
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
    @can('create-discount')
        <livewire:discount.create/>
    @endcan
    @can('delete-discount')
        <livewire:discount.delete/>
    @endcan
        @section('title')
            مدیریت تخفیف ها
        @endsection
        @section('description')
            مدیریت تخفیف ها
        @endsection
</x-base-layout>
