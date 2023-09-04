<x-base-layout>

    <!--begin::Card-->
    <div class="card">
        <!--begin::Card body-->
        <div class="card-body pt-6">
            @include('pages.transactions._table')
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
    @section('title')
        لیست تراکنش ها
    @endsection
    @section('description')
        لیست تراکنش ها
    @endsection
</x-base-layout>
