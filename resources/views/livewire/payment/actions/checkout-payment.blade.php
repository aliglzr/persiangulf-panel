<div>
    {{-- Do your work, then step back. --}}
</div>
@push('scripts')
    <script>
        function checkoutPayment(paymentId) {
            Swal.fire({
                icon: "question",
                title: 'آیا از تسویه کردن این پرداخت اطمینان دارید؟' ,
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
                @this.checkoutPayment(paymentId);
                }
            })
        }

        document.addEventListener('updateTable', function () {
            let table = window.window.LaravelDataTables['payments-table'];
            if (table) {
                table.ajax.reload();
            }
        });
    </script>
@endpush
