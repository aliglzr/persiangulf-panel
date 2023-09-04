<x-base-layout>
    @section('title')
        نمایندگان
    @endsection
    @section('description')
        نمایش لیست نمایندگان
    @endsection

        @section('actions')
            @can('create-agent')
            <div class="d-flex align-items-center py-1">
                <!--begin::Wrapper-->
                <div>
                    <a href="{{route('agents.create')}}" class="btn btn-sm btn-primary fw-bolder">
                        <span style="margin-left: 0.5rem">افزودن نماینده</span>
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
            @include('pages.agent._table')
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->


</x-base-layout>
