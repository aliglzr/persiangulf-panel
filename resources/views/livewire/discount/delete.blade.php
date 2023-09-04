<div></div>
@push('scripts')
    <script>
        function deleteDiscount(id) {
            Swal.fire({
                title: 'حذف کد تخفیف',
                text: "آیا از حذف کد تخفیف اطمینان دارید؟",
                icon: 'warning',
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-secondary",
                },
                confirmButtonText: 'بله',
                cancelButtonText: 'انصراف',

            }).then((result) => {
                if (result.isConfirmed) {
                @this.deleteDiscount(id);
                }
            })
        }

        document.addEventListener('refreshDiscountTable',function () {
            let table = window.window.LaravelDataTables['discounts-table'];
            if (table) {
                table.ajax.reload();
            }
        })
    </script>
@endpush
