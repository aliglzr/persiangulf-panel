<x-base-layout>

    <!--begin::Card-->
    <div class="card">
        <!--begin::Card body-->
        <div class="card-body pt-6">
            @include('pages.invoice._table')
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
    @can('reverse-invoice')
    <livewire:invoice.reversal />
    @endcan
    @section('title')
مدیریت فاکتور ها
    @endsection
    @section('description')
مدیریت فاکتور ها
    @endsection
</x-base-layout>
