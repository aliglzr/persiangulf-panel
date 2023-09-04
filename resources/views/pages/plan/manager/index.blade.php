<x-base-layout>

    @section('actions')
        @can('modify-plan')
        <div class="d-flex align-items-center py-1">
            <!--begin::Wrapper-->
            <div>
                <a href="#" class="btn btn-sm btn-primary fw-bolder" data-bs-toggle="modal"
                   data-bs-target="#createPlanModal" id="createPlanButton">
                    <span style="margin-left: 0.5rem">افزودن طرح</span>
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
            @include('pages.plan.manager._table')
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
    @can('modify-plan')
        <livewire:plan.management.create/>
    @endcan
    @can('delete-plan')
        <livewire:plan.management.delete/>
    @endcan

        @section('title')
            لیست طرح ها
        @endsection
        @section('description')
            لیست طرح ها
        @endsection


</x-base-layout>
