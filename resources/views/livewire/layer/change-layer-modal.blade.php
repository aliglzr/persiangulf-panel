<div wire:ignore.self class="modal fade" tabindex="-1" id="changeLayerModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-gray-900">تغییر لایه</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                     aria-label="Close">
                    <span class="svg-icon svg-icon-1"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <div class="fv-row mb-7">
                    <div wire:ignore>
                        <!--begin::Label-->
                        <label class="fw-bold fs-6 mb-3">
                            لایه
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <select id="select_layer_id" aria-label="انتخاب مشتری"
                                class="form-select form-select-solid form-select-lg fw-bold">
                            <option value="">انتخاب لایه</option>
                            @foreach($layers as $layer)
                                <option value="{{ $layer->id }}">{{$layer->name}} - ({{$layer->users()->count()}}
                                    مشتری)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light"
                        data-bs-dismiss="modal">بستن
                </button>
                <button type="submit" wire:click.prevent="changeLayer()" class="btn btn-primary">
                    <!--begin::Indicator-->
                    <span class="indicator-label" wire:target="changeLayer" wire:loading.class="d-none">
تغییر لایه
</span>
                    <span class="indicator-progress" wire:target="changeLayer" wire:loading.class="d-block">
    در حال پردازش
    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
</span>
                    <!--end::Indicator-->
                </button>
            </div>

        </div>

    </div>
</div>

@push('scripts')
    <script>
        function setModel($model_id,$type) {
            @this.emit('setModel',{'model_id':$model_id,'type': $type});
        }

        const changeLayerModal = document.getElementById('changeLayerModal')
        changeLayerModal.addEventListener('hidden.bs.modal', event => {
            @this.resetModal();
            $("#select_layer_id").val("").trigger('change');
        });

        document.addEventListener('toggleChangeLayerModal', (e) => {
            let currentLayer = e.detail.currentLayerId;
            $("#select_layer_id").val(currentLayer).trigger('change');
            let refresh = e.detail.refresh;
            $('#changeLayerModal').modal('toggle');
            if (refresh === 'refreshClientTable') {
                let table = window.window.LaravelDataTables['clients-table'];
                if (table) {
                    table.ajax.reload();
                }
            }
            if (refresh === 'refreshClientTable') {
                table = window.window.LaravelDataTables['servers-table'];
                if (table) {
                    table.ajax.reload();
                }
            }
        });

        document.addEventListener('livewire:load', function () {
            $('#select_layer_id').select2({
                placeholder: "انتخاب لایه",
                dropdownParent: $('#changeLayerModal'),
                allowClear: true,
            }).on('change', function () {
                @this.
                set('layer_id', $(this).val());
            });
        });

        document.addEventListener('livewire:dehydrate', function () {
            $('#select_layer_id').select2({
                placeholder: "انتخاب لایه",
                dropdownParent: $('#changeLayerModal'),
                allowClear: true,
            }).on('change', function () {
                @this.
                set('layer_id', $(this).val());
            });
        });

    </script>
@endpush

