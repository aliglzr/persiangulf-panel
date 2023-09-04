<!--begin::Table-->
{{ $dataTable->table() }}
<!--end::Table-->

{{-- Inject Scripts --}}
@push('styles')
    <script src="{{asset('plugins/custom/datatables/datatables.bundle.css')}}"></script>
@endpush
@push('scripts')
    <script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
    {{ $dataTable->scripts() }}
@endpush
