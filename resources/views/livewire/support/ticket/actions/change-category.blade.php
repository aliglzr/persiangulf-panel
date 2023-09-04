<div wire:ignore.self class="modal fade" id="changeCategoryModal" tabindex="-1" aria-hidden="true"
     xmlns:wire="http://www.w3.org/1999/xhtml">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form wire:submit.prevent="changeCategory()" class="form" id="createServerModalForm">
                <!--begin::Modal header-->
                <div class="modal-header" id="createServerModalHeader">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">ارجاع به واحد دیگر</h2>
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
                            <div wire:ignore class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fw-bold fs-6">
                                    <span class="required">انتخاب واحد</span>

                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                       title="انتخاب واحد پاسخگو به تیکت"></i>
                                </label>
                                <!--end::Label-->

                                <!--begin::Col-->
                                <select id="change_category" aria-label="انتخاب لایه"
                                        class="form-select form-select-solid form-select-lg fw-bold">
                                    <option value="">انتخاب واحد</option>
                                    @foreach(\Coderflex\LaravelTicket\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Col-->
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
        const changeCategoryModal = document.getElementById('changeCategoryModal')
        changeCategoryModal.addEventListener('hidden.bs.modal', event => {
        @this.resetModal();
        });

        document.addEventListener('toggleCategoryModal', function () {
            $('#changeCategoryModal').modal('toggle');
        });

        document.addEventListener('livewire:load', function () {
            $('#change_category').select2({
                placeholder: "انتخاب واحد",
                dropdownParent: $('#changeCategoryModal'),
                allowClear: true,
            }).on('change', function () {
            @this.set('ticket.category_id', $(this).val());
            });
            $("#change_category").val(@this.ticket['category_id']).trigger('change');
        })


    </script>
@endpush



