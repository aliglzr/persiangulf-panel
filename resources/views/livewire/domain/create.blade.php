<div wire:ignore.self class="modal fade" id="createDomainModal" tabindex="-1" aria-hidden="true"
     xmlns:wire="http://www.w3.org/1999/xhtml">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form wire:submit.prevent="create" class="form" id="createDomainModalForm">
                <!--begin::Modal header-->
                <div class="modal-header" id="createDomainModalHeader">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">{{$editMode ? 'ویرایش دامنه' : 'افزودن دامنه جدید'}}</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close"
                         data-bs-dismiss="modal">
                        {!! get_svg_icon('icons/duotune/general/gen034.svg','svg-icon svg-icon-2x text-danger') !!}
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Scroll-->
                    <div wire:ignore.self class="d-flex flex-column scroll-y me-n7 pe-7"
                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_user_header"
                         data-kt-scroll-wrappers="#kt_modal_update_user_scroll" data-kt-scroll-offset="300px">
                        <!--begin::User form-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold mb-2">دامنه</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text"
                                   class="form-control @error('domain.hostname') is-invalid @enderror form-control-solid"
                                   wire:model.defer="domain.hostname"/>
                            @error('domain.hostname')
                            <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div wire:ignore class="fv-row mb-7">
                            <div>
                                <!--begin::Label-->
                                <label class="fw-bold fs-6">
                                    <span class="required">سرور</span>

                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                       title="انتخاب سرور"></i>
                                </label>
                                <!--end::Label-->

                                <!--begin::Col-->
                                <select id="select_server" aria-label="انتخاب سرور"
                                        class="form-select form-select-solid form-select-lg fw-bold">
                                    <option value="">انتخاب سرور</option>
                                    @foreach(\App\Models\Server::all() as $server)
                                        <option value="{{ $server->id }}">{{ $server->name .' - '. $server->ip_address }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div wire:ignore class="fv-row mb-7">
                            <div>
                                <!--begin::Label-->
                                <label class="fw-bold fs-6">
                                    <span class="required">CDN</span>

                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                       title="انتخاب CDN"></i>
                                </label>
                                <!--end::Label-->

                                <!--begin::Col-->
                                <select id="select_cdn" aria-label="انتخاب CDN"
                                        class="form-select form-select-solid form-select-lg fw-bold">
                                    <option value="ac" selected>Arvan Cloud</option>
                                    <option value="cf">Cloud Flare</option>
                                </select>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">وضعیت دامنه</label>
                            <!--begin::Label-->

                            <!--begin::Label-->
                            <div class="col-lg-8 d-flex align-items-center">
                                <!--begin::Radio group-->
                                <div wire:ignore.self class="btn-group w-100 w-lg-50" data-kt-buttons="true"
                                     data-kt-buttons-target="[data-kt-button]">
                                    <!--begin::Radio-->
                                    <label
                                            class="btn btn-outline btn-color-muted btn-active-primary {{$domain->active ? 'active' : ''}}"
                                            data-kt-button="true">
                                        <!--begin::Input-->
                                        <input class="btn-check" type="radio" wire:model.lazy="domain.active"
                                               value="1" checked="{{$domain->active ? 'checked' : ''}}"/>
                                        <!--end::Input-->
                                        فعال
                                    </label>
                                    <!--end::Radio-->


                                    <!--begin::Radio-->
                                    <label
                                            class="btn btn-outline btn-color-muted btn-active-danger {{!$domain->active ? 'active' : ''}}"
                                            data-kt-button="true">
                                        <!--begin::Input-->
                                        <input class="btn-check" type="radio" wire:model.lazy="domain.active"
                                               value="0" checked="{{!$domain->active ? 'checked' : ''}}"/>
                                        <!--end::Input-->
                                        غیر فعال
                                    </label>
                                    <!--end::Radio-->
                                </div>
                                <!--end::Radio group-->
                                @error('domain.active')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            </div>
                            <!--begin::Label-->
                        </div>
                        <!--end::Input group-->

                        <!--end::User form-->
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button wire:target="create" wire:loading.attr="disabled" type="button" class="btn btn-light me-3"
                            data-kt-users-modal-action="cancel"
                            data-bs-dismiss="modal">{{__('messages.Discard')}}</button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" wire:loading.attr="disabled" class="btn btn-primary">
                        <span class="indicator-label" wire:target="create" wire:loading.class="d-none">ثبت</span>
                        <span class="indicator-progress" wire:target="create" wire:loading.class="d-block">در حال ثبت
														<span
                                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>
@push('scripts')
    <script>
        const createDomainModal = document.getElementById('createDomainModal')
        createDomainModal.addEventListener('hidden.bs.modal', event => {
            @this.
            resetModal();
            $("#select_server").val("").trigger('change');
            $("#select_cdn").val("").trigger('change');
        });

        document.addEventListener('toggleDomainModal', function () {
            $('#createDomainModal').modal('toggle');
            let table = window.window.LaravelDataTables['domains-table'];
            if (table) {
                table.ajax.reload();
            }
        });

        function editDomain(id) {
            @this.
            emit('editDomain', id);
        }


        // Format options

        document.addEventListener('livewire:load', function () {

            $('#select_server').select2({
                placeholder: "انتخاب سرور",
                dropdownParent: $('#createDomainModal'),
                allowClear: true,
            }).on('change', function () {
                @this.
                set('domain.server_id', $(this).val());
            });

            $('#select_cdn').select2({
                placeholder: "انتخاب CDN",
                dropdownParent: $('#createDomainModal'),
                allowClear: true,
            }).on('change', function () {
                @this.
                set('domain.cdn', $(this).val());
            });
        })



        document.addEventListener('setSelectValues', function (data) {
            data = data.detail;
            $("#select_server").val(data['server_id']).trigger('change');
            $("#select_cdn").val(data['cdn']).trigger('change');
        })

    </script>
@endpush



