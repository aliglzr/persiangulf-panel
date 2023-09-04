<div wire:ignore.self class="modal fade" tabindex="-1" id="deleteDomainModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-gray-900">حذف دامنه</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                     aria-label="Close">
                    <span class="svg-icon svg-icon-1"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">

                <h2>آیا مایل به حذف دامنه {{$domain?->hostname}} هستید؟</h2>

            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">انصراف</button>
                <button type="button" wire:click.prevent="deleteDomain()" class="btn btn-danger">حذف</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
document.getElementById('deleteDomainModal').addEventListener('hidden.bs.modal', event => {
        @this.resetDeleteModal();
        });

        function deleteDomain(id){
            @this.emit('deleteDomain',id);
        }

        document.addEventListener('toggleDeleteDomainModal',() => {
            $('#deleteDomainModal').modal('toggle');
            let table = window.window.LaravelDataTables['domains-table'];
            if (table) {
                table.ajax.reload();
            }
        });
    </script>
    @endpush
