<div wire:ignore.self class="modal fade" id="createDiscountModal" tabindex="-1" aria-hidden="true"
     xmlns:wire="http://www.w3.org/1999/xhtml">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form wire:submit.prevent="create" class="form" id="createDiscountModalForm">
                <!--begin::Modal header-->
                <div class="modal-header" id="createDiscountModalHeader">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">{{$editMode ? 'ویرایش کد تخفیف' : 'افزودن کد تخفیف'}}</h2>
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
                         id="kt_modal_create_resource_scroll"
                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_update_user_header"
                         data-kt-scroll-wrappers="#kt_modal_update_user_scroll" data-kt-scroll-offset="300px">
                        <!--begin::User form-->
                        <div id="kt_modal_update_user_user_info">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">کد</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('discount.code') is-invalid @enderror form-control-solid"
                                       wire:model.defer="discount.code"/>
                                @error('discount.code')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">تعداد</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('discount.remaining_count') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.defer="discount.remaining_count"/>
                                @error('discount.remaining_count')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">درصد تخفیف</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('discount.percent') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.defer="discount.percent"/>
                                @error('discount.percent')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">بیشینه تخفیف (به تومان)</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('discount.max') is-invalid @enderror form-control-solid"
                                       wire:model.defer="discount.max"/>
                                @error('discount.max')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->


                            <!--begin::Input group-->
                            <div wire:ignore class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">تاریخ اعتبار</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input dir="ltr" type="text" id="expires_at"
                                       class="form-control @error('discount.expires_at') is-invalid @enderror form-control-solid"
                                       placeholder="" wire:model.defer="discount.expires_at"/>
                                @error('discount.expires_at')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                            <div wire:ignore>
                                <!--begin::Label-->
                                <label class="fw-bold fs-6">
                                    <span class="required">انتخاب نماینده</span>

                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                       title="انتخاب نماینده"></i>
                                </label>
                                <!--end::Label-->

                                <!--begin::Col-->
                                <select id="select_agent" aria-label="انتخاب نماینده"
                                        class="form-select form-select-solid form-select-lg fw-bold">
                                    <option >انتخاب نماینده</option>
                                    @foreach(\App\Models\User::role('agent')->get() as $agent)
                                        <option value="{{ $agent->id }}">{{ $agent->username }}</option>
                                    @endforeach
                                </select>
                                <!--end::Col-->
                            </div>
                                @error('discount.user_id')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <div wire:ignore>
                                    <label class="fw-bold fs-6">
                                        <span class="required">انتخاب طرح</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                           title="انتخاب طرح"></i>
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Col-->
                                    <select id="select_plan" aria-label="انتخاب طرح"
                                            class="form-select form-select-solid form-select-lg fw-bold">
                                        <option>انتخاب طرح</option>
                                        @foreach(\App\Models\Plan::all() as $plan)
                                            <option value="{{ $plan->id }}">{{ $plan->title }}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Col-->
                                </div>
                                @error('discount.plan_id')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
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
                                            class="btn btn-outline btn-color-muted btn-active-primary {{$discount->active ? 'active' : ''}}"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" wire:model.defer="discount.active"
                                                   value="1" checked="{{$discount->active ? 'checked' : ''}}"/>
                                            <!--end::Input-->
                                            فعال
                                        </label>
                                        <!--end::Radio-->


                                        <!--begin::Radio-->
                                        <label
                                            class="btn btn-outline btn-color-muted btn-active-danger {{!$discount->active ? 'active' : ''}}"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" wire:model.defer="discount.active"
                                                   value="0" checked="{{!$discount->active ? 'checked' : ''}}"/>
                                            <!--end::Input-->
                                            غیر فعال
                                        </label>
                                        <!--end::Radio-->
                                    </div>
                                    <!--end::Radio group-->
                                    @error('discount.active')
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
                    <button type="reset" wire:target="create" wire:loading.attr="disabled" class="btn btn-light me-3" data-kt-users-modal-action="cancel"
                            data-bs-dismiss="modal">{{__('messages.Discard')}}</button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="submit" class="btn btn-primary" wire:target="create" wire:loading.attr="disabled">
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
        const createDiscountModal = document.getElementById('createDiscountModal')
        createDiscountModal.addEventListener('hidden.bs.modal', event => {
        @this.resetModal();
            $("#select_agent").val("").trigger('change');
            $("#select_plan").val("").trigger('change');
        });

        document.addEventListener('toggleDiscountModal', function () {
            $('#createDiscountModal').modal('toggle');
            let table = window.window.LaravelDataTables['discounts-table'];
            if (table) {
                table.ajax.reload();
            }
        });

        document.addEventListener('livewire:load', function () {
            $('#expires_at').daterangepicker({
                timePicker: true,
                autoUpdateInput: false,
                singleDatePicker: true,
                showDropdowns: true,
                nullable: true,
                minYear: parseInt(moment().format('YYYY'), 10),
                maxYear: 2040,
                locale: {
                    format: 'YYYY/MM/DD HH:mm:ss'
                }
            }, function (datetime) {
            @this.set('discount.expires_at', moment(datetime).format('YYYY/MM/DD HH:mm:ss'));
            });

            // Init Select2 --- more info: https://select2.org/
            $('#select_agent').select2({
                placeholder: "انتخاب نماینده",
                dropdownParent: $('#createDiscountModal'),
                allowClear: true,
            }).on('change', function () {
            @this.set('discount.user_id', $(this).val());
            });

            $('#select_plan').select2({
                placeholder: "انتخاب طرح",
                dropdownParent: $('#createDiscountModal'),
                allowClear: true,
            }).on('change', function () {
            @this.set('discount.plan_id', $(this).val());
            });

        });

        function editDiscount(id) {
        @this.emit('editDiscount', id);
        }

        document.addEventListener('setSelectValues', function (data) {
            data = data.detail;
            $("#select_agent").val(data['user_id']).trigger('change');
            $("#select_plan").val(data['plan_id']).trigger('change');
        })


    </script>
@endpush



