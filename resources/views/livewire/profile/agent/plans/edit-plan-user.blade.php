<div wire:ignore.self class="modal fade" id="editPlanUserModal" tabindex="-1" aria-hidden="true"
     xmlns:wire="http://www.w3.org/1999/xhtml">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form wire:submit.prevent="edit" class="form" id="editPlanUserModalForm">
                <!--begin::Modal header-->
                <div class="modal-header" id="editPlanUserModalHeader">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">ویرایش طرح</h2>
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
                         data-kt-scroll-max-height="auto" data-kt-scroll-offset="300px">
                        <!--begin::User form-->
                        <div>
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">عنوان طرح</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('planUser.plan_title') is-invalid @enderror form-control-solid"
                                       wire:model.lazy="planUser.plan_title"/>
                                @error('planUser.plan_title')
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
                                       class="form-control @error('planUser.plan_duration') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="planUser.plan_duration"/>
                                @error('planUser.plan_duration')
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
                                       class="form-control @error('planUser.plan_users_count') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="planUser.plan_users_count"/>
                                @error('planUser.plan_users_count')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">تعداد باقی مانده</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('planUser.remaining_user_count') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="planUser.remaining_user_count"/>
                                @error('planUser.remaining_user_count')
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
                                       class="form-control @error('planUser.plan_price') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="planUser.plan_price"/>
                                @error('PlanUser.plan_price')
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
                                       class="form-control @error('planUser.plan_sell_price') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="planUser.plan_sell_price"/>
                                @error('PlanUser.plan_sell_price')
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
                                            class="btn btn-outline btn-color-muted btn-active-primary {{$planUser->active ? 'active' : ''}}"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" wire:model.lazy="planUser.active"
                                                   value="1" checked="{{$planUser->active ? 'checked' : ''}}"/>
                                            <!--end::Input-->
                                            فعال
                                        </label>
                                        <!--end::Radio-->


                                        <!--begin::Radio-->
                                        <label
                                            class="btn btn-outline btn-color-muted btn-active-danger {{!$planUser->active ? 'active' : ''}}"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" wire:model.lazy="planUser.active"
                                                   value="0" checked="{{!$planUser->active ? 'checked' : ''}}"/>
                                            <!--end::Input-->
                                            غیر فعال
                                        </label>
                                        <!--end::Radio-->
                                    </div>
                                    <!--end::Radio group-->
                                    @error('planUser.active')
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
        const editPlanUserModal = document.getElementById('editPlanUserModal')
        editPlanUserModal.addEventListener('hidden.bs.modal', event => {
        @this.resetModal();
        });

        document.addEventListener('togglePlanUserModal', function () {
            $('#editPlanUserModal').modal('toggle');
        });

    </script>
@endpush



