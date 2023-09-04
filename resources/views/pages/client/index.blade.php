<x-base-layout>
    @section('title')
       لیست مشتریان
    @endsection
    @section('description')
            لیست مشتریان
    @endsection

    <!--begin::Card-->
    <div class="card">
        <!--begin::Card body-->
        <div class="card-body pt-6">
            @include('pages.client._table')
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

        @can('change-client-layer')
            <livewire:layer.change-layer-modal/>
        @endcan

        <livewire:profile.agent.plans.renew-subscription />

</x-base-layout>
