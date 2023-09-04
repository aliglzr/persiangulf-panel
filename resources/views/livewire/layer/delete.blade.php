<div wire:ignore.self class="modal fade" tabindex="-1" id="deleteLayerModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-gray-900">شما در حال حذف لایه هستید</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                     aria-label="Close">
                    <span class="svg-icon svg-icon-1"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <label for="password"
                       class=" col-lg-4 col-form-label fs-6 fw-bolder">دلیل حذف لایه</label>
                <textarea wire:model.lazy="reason" class="form-control @error('reason') is-invalid @enderror"></textarea>
                @error('reason')
                <div class="invalid-feedback" role="alert">{{$message}}</div>
                @enderror

                <label for="two_factor"
                       class=" col-lg-4 col-form-label fs-6 fw-bolder">کد تایید دو عاملی</label>
                <input wire:model.lazy="two_factor" class="form-control @error('two_factor') is-invalid @enderror ">
                @error('two_factor')
                <div class="invalid-feedback" role="alert">{{$message}}</div>
                @enderror

            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">انصراف</button>
                <button type="button" wire:click.prevent="deleteLayer()" class="btn btn-primary">تایید</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
document.getElementById('deleteLayerModal').addEventListener('hidden.bs.modal', event => {
        @this.resetDeleteModal();
        });

        function deleteLayer(id){
            @this.emit('deleteLayer',id);
        }

        document.addEventListener('toggleDeleteLayerModal',() => {
            $('#deleteLayerModal').modal('toggle');
            let table = window.window.LaravelDataTables['layers-table'];
            if (table) {
                table.ajax.reload();
            }
        });
    </script>
    @endpush
