<x-base-layout xmlns:livewire>
    <!--begin::Card-->
    <div class="card">
        <!--begin::Card body-->
        <div class="card-body pt-6">
            @include('pages.wallet._table')
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

<livewire:wallet.delete />

    @section('title')
        لیست کیف پول ها
    @endsection
    @section('description')
        لیست کیف پول ها
    @endsection

</x-base-layout>
