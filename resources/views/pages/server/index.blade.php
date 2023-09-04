<x-base-layout>
    @push('scripts')
        <script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
    @endpush
    @push('styles')
        <link rel="stylesheet" href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}">
    @endpush
    @section('actions')
        @can('modify-server')
        <div class="d-flex align-items-center py-1">
            <!--begin::Wrapper-->
            <div>
                <a href="#" class="btn btn-sm btn-primary fw-bolder" data-bs-toggle="modal" data-bs-target="#createServerModal" id="createServerButton">
                    <span style="margin-left: 0.5rem">افزودن سرور</span>
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
            @include('pages.server._table')
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
        @can('modify-server')
        <livewire:server.create />
        @endcan
        @can('delete-server')
        <livewire:server.delete />
        @endcan
    @can('change-server-layer')
            <livewire:layer.change-layer-modal/>
        @endcan
        @section('title')
            لیست سرور ها
        @endsection
        @section('description')
            لیست سرور ها
        @endsection
</x-base-layout>
