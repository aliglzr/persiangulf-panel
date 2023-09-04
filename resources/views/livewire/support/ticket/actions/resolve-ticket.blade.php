<div>
    {{-- Do your work, then step back. --}}
</div>
@push('scripts')
    <script>
        function toggleResolvingTicket(ticket_id){
            Swal.fire({
                icon: "question",
                title: 'آیا از تغییر وضعیت این تیکت به حل شده، اطمینان دارید؟',
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
                @this.toggleResolvingTicket(ticket_id);
                }
            })
        }

        document.addEventListener('updateTable', function () {
            let table = window.window.LaravelDataTables['tickets-table'];
            if (table) {
                table.ajax.reload();
            }
        });
    </script>
@endpush