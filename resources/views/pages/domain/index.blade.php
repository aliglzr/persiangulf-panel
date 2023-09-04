<x-base-layout>
    @push('scripts')
        <script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
    @endpush
    @push('styles')
        <link rel="stylesheet" href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}">
    @endpush
    @section('actions')
        @can('modify-domain')
        <div class="d-flex align-items-center py-1">
            <!--begin::Wrapper-->
            <div>
                <a href="#" class="btn btn-sm btn-primary fw-bolder" data-bs-toggle="modal" data-bs-target="#createDomainModal" id="createDomainButton">
                    <span style="margin-left: 0.5rem">افزودن دامنه</span>
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
            @include('pages.domain._table')
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
        @can('modify-domain')
        <livewire:domain.create />
        @endcan
        @can('delete-domain')
        <livewire:domain.delete />
        @endcan
        @section('title')
            لیست دامنه ها
        @endsection
        @section('description')
            لیست دامنه ها
        @endsection
</x-base-layout>
