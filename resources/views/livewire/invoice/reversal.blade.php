<div>
    {{-- Do your work, then step back. --}}
</div>
@push('scripts')
    <script>
        function invoiceReversal(invoice_id){
            Swal.fire({
                icon: "question",
                title: 'آیا از برگشت این فاکتور اطمینان دارید؟',
                showCancelButton: true,
                confirmButtonText: 'بله',
                cancelButtonText: 'خیر',
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-secondary",
                }
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    @this.reverseInvoice(invoice_id);
                }
            })
        }

        document.addEventListener('updateTable', function () {
            let table = window.window.LaravelDataTables['invoices-table'];
            if (table) {
                table.ajax.reload();
            }
        });
    </script>
    @endpush
