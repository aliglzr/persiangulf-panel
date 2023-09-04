<div wire:ignore.self class="modal fade" id="createServerModal" tabindex="-1" aria-hidden="true"
     xmlns:wire="http://www.w3.org/1999/xhtml">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form wire:submit.prevent="create" class="form" id="createServerModalForm">
                <!--begin::Modal header-->
                <div class="modal-header" id="createServerModalHeader">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">{{$editMode ? 'ویرایش سرور' : 'افزودن سرور جدید'}}</h2>
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
                        <!--begin::Server form-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">نام سرور</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('server.name') is-invalid @enderror form-control-solid"
                                       wire:model.defer="server.name"/>
                                @error('server.name')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">آدرس آیپی</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('server.ip_address') is-invalid @enderror form-control-solid"
                                       wire:model.defer="server.ip_address"/>
                                @error('server.ip_address')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">ماکسیمم کانکشن</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('server.max_connections') is-invalid @enderror form-control-solid"
                                       wire:model.defer="server.max_connections"/>
                                @error('server.max_connections')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">پهنای باند (بر حسب GB)</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('bandwidth') is-invalid @enderror form-control-solid"
                                       wire:model.defer="bandwidth"/>
                                @error('bandwidth')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->



                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">آدرس کلید خصوصی</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input dir="ltr" type="text"
                                       class="form-control @error('server.private_key') is-invalid @enderror form-control-solid"
                                       wire:model.defer="server.private_key"/>
                                @error('server.private_key')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">آدرس کلید عمومی</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input dir="ltr" type="text"
                                       class="form-control @error('server.public_key') is-invalid @enderror form-control-solid"
                                       wire:model.defer="server.public_key"/>
                                @error('server.public_key')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->


                            <!--begin::Input group-->
                            <div wire:ignore class="fv-row mb-7">
                                <div>
                                    <!--begin::Label-->
                                    <label class="fw-bold fs-6">
                                        <span class="required">کشور</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                           title="انتخاب کشور سرور"></i>
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Col-->
                                    <select id="select_country" aria-label="انتخاب کشور"
                                            class="form-select form-select-solid form-select-lg fw-bold">
                                        <option value="">انتخاب کشور</option>
                                        @foreach(\App\Models\Country::all() as $value)
                                            <option data-kt-flag="{{asset('media/'.$value->flag)}}"
                                                    value="{{ $value->id }}">{{ $value->slug }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">شهر</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text"
                                       class="form-control @error('server.city') is-invalid @enderror form-control-solid"
                                       wire:model.defer="server.city"/>
                                @error('server.city')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div wire:ignore class="fv-row mb-7">
                                <div>
                                    <!--begin::Label-->
                                    <label class="fw-bold fs-6">
                                        <span class="required">لایه</span>

                                        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                           title="انتخاب لایه سرور"></i>
                                    </label>
                                    <!--end::Label-->

                                    <!--begin::Col-->
                                    <select id="select_layer" aria-label="انتخاب لایه"
                                            class="form-select form-select-solid form-select-lg fw-bold">
                                        <option value="">انتخاب لایه</option>
                                        @foreach(\App\Models\Layer::all() as $layer)
                                            <option value="{{ $layer->id }}">{{ $layer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">توضیحات</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea type="text"
                                          class="form-control @error('server.description') is-invalid @enderror form-control-solid"
                                          wire:model.defer="server.description"></textarea>
                                @error('server.description')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            <!--end::Input-->
                            </div>
                            <!--end::Input group-->


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-bold fs-6">وضعیت سرور</label>
                                <!--begin::Label-->

                                <!--begin::Label-->
                                <div class="col-lg-8 d-flex align-items-center">
                                    <!--begin::Radio group-->
                                    <div wire:ignore.self class="btn-group w-100 w-lg-50" data-kt-buttons="true"
                                         data-kt-buttons-target="[data-kt-button]">
                                        <!--begin::Radio-->
                                        <label
                                            class="btn btn-outline btn-color-muted btn-active-primary {{$server->active ? 'active' : ''}}"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" wire:model.lazy="server.active"
                                                   value="1" checked="{{$server->active ? 'checked' : ''}}"/>
                                            <!--end::Input-->
                                            فعال
                                        </label>
                                        <!--end::Radio-->


                                        <!--begin::Radio-->
                                        <label
                                            class="btn btn-outline btn-color-muted btn-active-danger {{!$server->active ? 'active' : ''}}"
                                            data-kt-button="true">
                                            <!--begin::Input-->
                                            <input class="btn-check" type="radio" wire:model.lazy="server.active"
                                                   value="0" checked="{{!$server->active ? 'checked' : ''}}"/>
                                            <!--end::Input-->
                                            غیر فعال
                                        </label>
                                        <!--end::Radio-->
                                    </div>
                                    <!--end::Radio group-->
                                    @error('server.active')
                                    <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                                <!--begin::Label-->
                            </div>
                            <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-bold fs-6">وضعیت در دسترس بودن</label>
                            <!--begin::Label-->

                            <!--begin::Label-->
                            <div class="col-lg-8 d-flex align-items-center">
                                <!--begin::Radio group-->
                                <div wire:ignore.self class="btn-group w-100 w-lg-50" data-kt-buttons="true"
                                     data-kt-buttons-target="[data-kt-button]">
                                    <!--begin::Radio-->
                                    <label
                                        class="btn btn-outline btn-color-muted btn-active-primary {{$server->available ? 'active' : ''}}"
                                        data-kt-button="true">
                                        <!--begin::Input-->
                                        <input class="btn-check" type="radio" wire:model.lazy="server.available"
                                               value="1" checked="{{$server->available ? 'checked' : ''}}"/>
                                        <!--end::Input-->
                                        فعال
                                    </label>
                                    <!--end::Radio-->


                                    <!--begin::Radio-->
                                    <label
                                        class="btn btn-outline btn-color-muted btn-active-danger {{!$server->available ? 'active' : ''}}"
                                        data-kt-button="true">
                                        <!--begin::Input-->
                                        <input class="btn-check" type="radio" wire:model.lazy="server.available"
                                               value="0" checked="{{!$server->available ? 'checked' : ''}}"/>
                                        <!--end::Input-->
                                        غیر فعال
                                    </label>
                                    <!--end::Radio-->
                                </div>
                                <!--end::Radio group-->
                                @error('server.available')
                                <div class="invalid-feedback">{{$message}}</div> @enderror
                            </div>
                            <!--begin::Label-->
                        </div>
                        <!--end::Input group-->

                        <!--end::Server form-->
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button wire:target="create" wire:loading.attr="disabled" type="button" class="btn btn-light me-3" data-kt-users-modal-action="cancel"
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
        const createServerModal = document.getElementById('createServerModal')
        createServerModal.addEventListener('hidden.bs.modal', event => {
        @this.resetModal();
            $("#select_country").val("").trigger('change');
            $("#select_layer").val("").trigger('change');
        });

        document.addEventListener('toggleServerModal', function () {
            $('#createServerModal').modal('toggle');
            let table = window.window.LaravelDataTables['servers-table'];
            if (table) {
                table.ajax.reload();
            }
        });

        function editServer(id) {
        @this.emit('editServer', id);
        }


        // Format options
        var optionFormat = function (item) {
            if (!item.id) {
                return item.text;
            }

            var span = document.createElement('span');
            var imgUrl = item.element.getAttribute('data-kt-flag');
            var template = '';

            template += '<img src="' + imgUrl + '" class="rounded-circle h-20px me-2" alt="image"/>';
            template += item.text;

            span.innerHTML = template;

            return $(span);
        }

        document.addEventListener('livewire:load', function () {
            $('#select_country').select2({
                templateSelection: optionFormat,
                templateResult: optionFormat,
                placeholder: "انتخاب کشور",
                dropdownParent: $('#createServerModal'),
                allowClear: true,
            }).on('change', function () {
            @this.set('server.country_id', $(this).val());
            });

            $('#select_layer').select2({
                placeholder: "انتخاب لایه",
                dropdownParent: $('#createServerModal'),
                allowClear: true,
            }).on('change', function () {
            @this.set('server.layer_id', $(this).val());
            });
        })

        document.addEventListener('setSelectValues',function (data) {
            data = data.detail;
            $("#select_country").val(data['country_id']).trigger('change');
            $("#select_layer").val( data['layer_id']).trigger('change');
        })

    </script>
@endpush



