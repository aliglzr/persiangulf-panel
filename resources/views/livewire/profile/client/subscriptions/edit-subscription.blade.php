<div wire:ignore.self class="modal fade" id="editSubscriptionModal" tabindex="-1" aria-hidden="true"
     xmlns:wire="http://www.w3.org/1999/xhtml">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form wire:submit.prevent="edit" class="form" id="editSubscriptionModalForm">
                <!--begin::Modal header-->
                <div class="modal-header" id="editSubscriptionModalHeader">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">ویرایش اشتراک</h2>
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
                                <label class="fs-6 fw-bold mb-2">مدت اعتبار (به روز)</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('subscription.duration') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="subscription.duration"/>
                                @error('subscription.duration')
                                <div class="invalid-feedback">{{convertNumbers($message)}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">کل ترافیک (مگابایت)</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('total_traffic') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.lazy="total_traffic"/>
                                @error('total_traffic')
                                <div class="invalid-feedback">{{convertNumbers($message)}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="form-group">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-bold fs-6">وضعیت</label>
                                <!--begin::Label-->

                                <!--begin::Label-->
                                <div class="col-lg-8 d-flex align-items-center">
                                    <!--begin::Radio group-->
                                    <div wire:ignore.self class="btn-group w-100 w-lg-50" data-kt-buttons="true"
                                         data-kt-buttons-target="[data-kt-button]">
                                        <!--begin::Radio-->
                                        <label
                                            class="btn btn-outline btn-color-muted btn-active-primary {{$subscription->using ? 'active' : ''}}"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" wire:model.lazy="subscription.using"
                                                   value="1" checked="{{$subscription->using ? 'checked' : ''}}"/>
                                            <!--end::Input-->
                                            فعال
                                        </label>
                                        <!--end::Radio-->


                                        <!--begin::Radio-->
                                        <label
                                            class="btn btn-outline btn-color-muted btn-active-danger {{$subscription->using ? '' : 'active'}}"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" wire:model.lazy="subscription.using"
                                                   value="0" checked="{{$subscription->using ? '' : 'checked'}}"/>
                                            <!--end::Input-->
                                            غیرفعال
                                        </label>
                                        <!--end::Radio-->
                                    </div>
                                    <!--end::Radio group-->
                                    @error('subscription.using')
                                    <div class="text-danger">{{$message}}</div> @enderror
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
                    <button type="submit" wire:target="edit" wire:loading.attr="disabled" class="btn btn-primary">
                        <span class="indicator-label" wire:target="edit" wire:loading.class="d-none">ثبت</span>
                        <span class="indicator-progress" wire:target="edit" wire:loading.class="d-block">در حال ثبت
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
        const editSubscriptionModal = document.getElementById('editSubscriptionModal')
        editSubscriptionModal.addEventListener('hidden.bs.modal', event => {
        @this.resetModal();
        });

        document.addEventListener('toggleEditSubscriptionModal', function () {
            $('#editSubscriptionModal').modal('toggle');
        });
        document.addEventListener('updateTable', function () {
            let table = window.window.LaravelDataTables['subscriptions-table'];
            if (table) {
                table.ajax.reload();
            }
        });

        function editSubscription(id) {
            @this.editMode(id);
        }

    </script>
@endpush



