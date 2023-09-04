<div>
    {{-- The best athlete wants his opponent at his best. --}}
</div>

@push('scripts')
    <script>
        function deleteTemplate(templateSlug) {
            Swal.fire({
                title: 'حذف قالب',
                text: "آیا از حذف کردن قالب اطمینان دارید؟",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'بله',
                cancelButtonText: 'انصراف',
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: 'btn btn-secondary'
                },
            }).then(function (result){
                if (result.isConfirmed){
                    @this.delete(templateSlug);
                }
            })
        }

        document.addEventListener('refreshTable',function () {
            let table = window.window.LaravelDataTables['templates-table'];
            if (table) {
                table.ajax.reload();
            }
        })
    </script>
    @endpush
