<div wire:ignore.self class="modal fade" id="createPlanModal" tabindex="-1" aria-hidden="true"
     xmlns:wire="http://www.w3.org/1999/xhtml">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form wire:submit.prevent="create" class="form" id="createPlanModalForm">
                <!--begin::Modal header-->
                <div class="modal-header" id="createPlanModalHeader">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">{{$editMode ? 'ویرایش طرح' : 'افزودن طرح جدید'}}</h2>
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
                    <div wire:ignore.self class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_create_resource_scroll"
                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_user_header"
                         data-kt-scroll-wrappers="#kt_modal_update_user_scroll" data-kt-scroll-offset="300px">
                        <!--begin::User form-->
                        <div id="kt_modal_update_user_user_info">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">عنوان طرح</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('plan.title') is-invalid @enderror form-control-solid"
                                       wire:model.lazy="plan.title"/>
                                @error('plan.title')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">مدت اعتبار (به روز)</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('plan.duration') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="plan.duration"/>
                                @error('plan.duration')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">تعداد کاربر</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('plan.users_count') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="plan.users_count"/>
                                @error('plan.users_count')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">محدودیت حجم (مگابایت)</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('traffic') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="traffic"/>
                                @error('traffic')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">قیمت (به تومان)</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('plan.price') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="plan.price"/>
                                @error('plan.price')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">قیمت منصفانه فروش (به تومان)</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('plan.sell_price') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="plan.sell_price"/>
                                @error('plan.sell_price')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">موجودی</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('plan.inventory') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="plan.inventory"/>
                                @error('plan.inventory')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">توضیحات</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea type="text"
                                          class="form-control @error('plan.description') is-invalid @enderror form-control-solid"
                                          placeholder="" wire:model.lazy="plan.description"></textarea>
                                @error('plan.description')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-bold fs-6">وضعیت طرح</label>
                                <!--begin::Label-->

                                <!--begin::Label-->
                                <div class="col-lg-8 d-flex align-items-center">
                                    <!--begin::Radio group-->
                                    <div wire:ignore.self class="btn-group w-100 w-lg-50" data-kt-buttons="true"
                                         data-kt-buttons-target="[data-kt-button]">
                                        <!--begin::Radio-->
                                        <label
                                            class="btn btn-outline btn-color-muted btn-active-primary {{$plan->active ? 'active' : ''}}"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" wire:model.lazy="plan.active"
                                                   value="1" checked="{{$plan->active ? 'checked' : ''}}"/>
                                            <!--end::Input-->
                                            فعال
                                        </label>
                                        <!--end::Radio-->


                                        <!--begin::Radio-->
                                        <label
                                            class="btn btn-outline btn-color-muted btn-active-danger {{!$plan->active ? 'active' : ''}}"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" wire:model.lazy="plan.active"
                                                   value="0" checked="{{!$plan->active ? 'checked' : ''}}"/>
                                            <!--end::Input-->
                                            غیر فعال
                                        </label>
                                        <!--end::Radio-->
                                    </div>
                                    <!--end::Radio group-->
                                    @error('plan.active')
                                    <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                                <!--begin::Label-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-bold fs-6">دسترسی به اشتراک</label>
                                <!--begin::Label-->

                                <!--begin::Label-->
                                <div class="col-lg-8 d-flex align-items-center">
                                    <!--begin::Radio group-->
                                    <div wire:ignore.self class="btn-group w-100 w-lg-50" data-kt-buttons="true"
                                         data-kt-buttons-target="[data-kt-button]">
                                        <!--begin::Radio-->
                                        <label
                                            class="btn btn-outline btn-color-muted btn-active-primary {{$plan->only_bot ? 'active' : ''}}"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" wire:model.lazy="plan.only_bot"
                                                   value="1" checked="{{$plan->only_bot ? 'checked' : ''}}"/>
                                            <!--end::Input-->
                                            فقط ربات
                                        </label>
                                        <!--end::Radio-->


                                        <!--begin::Radio-->
                                        <label
                                            class="btn btn-outline btn-color-muted btn-active-danger {{!$plan->only_bot ? 'active' : ''}}"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" wire:model.lazy="plan.only_bot"
                                                   value="0" checked="{{!$plan->only_bot ? 'checked' : ''}}"/>
                                            <!--end::Input-->
                                            همه کاربران
                                        </label>
                                        <!--end::Radio-->
                                    </div>
                                    <!--end::Radio group-->
                                    @error('plan.only_bot')
                                    <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                                <!--begin::Label-->
                            </div>
                            <!--end::Input group-->
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
                    <button type="submit" wire:target="create" wire:loading.attr="disabled" class="btn btn-primary">
                        <span wire:target="create" class="indicator-label" wire:loading.class="d-none">ثبت</span>
                        <span wire:target="create" class="indicator-progress" wire:loading.class="d-block">در حال ثبت
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
        const createPlanModal = document.getElementById('createPlanModal')
        createPlanModal.addEventListener('hidden.bs.modal', event => {
        @this.resetModal();
        });

        document.addEventListener('togglePlanModal', function () {
            $('#createPlanModal').modal('toggle');
            let table = window.window.LaravelDataTables['plans-table'];
            if (table) {
                table.ajax.reload();
            }
        });

       function editPlan(id)
        {
        @this.emit('editPlan', id);
        }
    </script>
@endpush



