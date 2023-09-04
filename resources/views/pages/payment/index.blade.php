<x-base-layout>

    <!--begin::Card-->
    <div class="card">
        <!--begin::Card body-->
        <div class="card-body pt-6">
            @if(auth()->user()->isManager())
                <livewire:payment.actions.checkout-payments />
                @endif
            @include('pages.payment._table')
        </div>
        <!--end::Card body-->
    </div>

    @if(auth()->user()->isManager())
        <livewire:payment.actions.checkout-payment />
        @endif

    <!--end::Card-->
    @section('title')
        لیست صورتحساب ها
    @endsection
    @section('description')
        لیست صورتحساب ها
    @endsection
{{--    @push('styles')--}}
{{--        <link rel="stylesheet" href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}">--}}
{{--    @endpush--}}
{{--    @push('scripts')--}}
{{--        <script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>--}}
{{--    @endpush--}}
</x-base-layout>
