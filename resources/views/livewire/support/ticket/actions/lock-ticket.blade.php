<div>
    {{-- Do your work, then step back. --}}
</div>
@push('scripts')
    <script>
        function toggleLockingTicket(ticket_id){
            var isTicketLocked;
            @this.isTicketLocked(ticket_id);
            isTicketLocked = @this.ticketLockStatus;

        }
        document.addEventListener('openTicketToggleModal',function (data) {
            Swal.fire({
                icon: "question",
                title: data.detail.ticketIsLocked ? 'آیا از باز کردن قفل این تیکت اطمینان دارید؟' : 'آیا از قفل شدن این تیکت اطمینان دارید؟',
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
                @this.toggleLockingTicket(data.detail.ticketId);
                }
            })
        })

        document.addEventListener('updateTable', function () {
            let table = window.window.LaravelDataTables['tickets-table'];
            if (table) {
                table.ajax.reload();
            }
        });
    </script>
@endpush