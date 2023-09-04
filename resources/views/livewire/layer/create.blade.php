<div wire:ignore.self class="modal fade" id="createLayerModal" tabindex="-1" aria-hidden="true"
     xmlns:wire="http://www.w3.org/1999/xhtml">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form wire:submit.prevent="create" class="form" id="createLayerModalForm">
                <!--begin::Modal header-->
                <div class="modal-header" id="createLayerModalHeader">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">{{$editMode ? 'ویرایش لایه' : 'افزودن لایه جدید'}}</h2>
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
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_create_resource_scroll"
                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_user_header"
                         data-kt-scroll-wrappers="#kt_modal_update_user_scroll" data-kt-scroll-offset="300px">
                        <!--begin::User form-->
                        <div id="kt_modal_update_user_user_info">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">عنوان لایه</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('layer.name') is-invalid @enderror form-control-solid"
                                       wire:model.lazy="layer.name"/>
                                @error('layer.name')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">ضریب</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('layer.load') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="layer.load"/>
                                @error('layer.load')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">سقف کاربر</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('layer.max_client') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="layer.max_client"/>
                                @error('layer.max_client')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">آدرس دیتابیس</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('layer.db_hostname') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="layer.db_hostname"/>
                                @error('layer.db_hostname')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">پورت دیتابیس</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('layer.db_port') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="layer.db_port"/>
                                @error('layer.db_port')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">نام دیتابیس</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('layer.db_name') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="layer.db_name"/>
                                @error('layer.db_name')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">نام کاربری</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('layer.db_username') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="layer.db_username"/>
                                @error('layer.db_username')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">گذرواژه</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('layer.db_password') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="layer.db_password"/>
                                @error('layer.db_password')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-bold fs-6">وضعیت لایه</label>
                                <!--begin::Label-->

                                <!--begin::Label-->
                                <div class="col-lg-8 d-flex align-items-center">
                                    <!--begin::Radio group-->
                                    <div wire:ignore.self class="btn-group w-100 w-lg-50" data-kt-buttons="true"
                                         data-kt-buttons-target="[data-kt-button]">
                                        <!--begin::Radio-->
                                        <label
                                            class="btn btn-outline btn-color-muted btn-active-primary {{$layer->active ? 'active' : ''}}"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" wire:model.lazy="layer.active"
                                                   value="1" checked="{{$layer->active ? 'checked' : ''}}"/>
                                            <!--end::Input-->
                                            فعال
                                        </label>
                                        <!--end::Radio-->


                                        <!--begin::Radio-->
                                        <label
                                            class="btn btn-outline btn-color-muted btn-active-danger {{!$layer->active ? 'active' : ''}}"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" wire:model.lazy="layer.active"
                                                   value="0" checked="{{!$layer->active ? 'checked' : ''}}"/>
                                            <!--end::Input-->
                                            غیر فعال
                                        </label>
                                        <!--end::Radio-->
                                    </div>
                                    <!--end::Radio group-->
                                    @error('layer.active')
                                    <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                                <!--begin::Label-->
                            </div>
                            <!--end::Input group-->
                            {{--                            TODO : Change Invesment Percent (Share)--}}
                        </div>
                        <!--end::User form-->
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel"
                            data-bs-dismiss="modal">{{__('messages.Discard')}}</button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">ثبت</span>
                        <span class="indicator-progress">در حال ثبت
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
        const createLayerModal = document.getElementById('createLayerModal')
        createLayerModal.addEventListener('hidden.bs.modal', event => {
        @this.resetModal();
        });

        document.addEventListener('toggleLayerModal', function () {
            $('#createLayerModal').modal('toggle');
            let table = window.window.LaravelDataTables['layers-table'];
            if (table) {
                table.ajax.reload();
            }
        });

        function editLayer(id)
        {
        @this.emit('editLayer', id);
        }
    </script>
@endpush



