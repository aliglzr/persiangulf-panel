<div wire:ignore.self class="modal fade" id="add_role" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">{{$editMode ? "ویرایش نقش $role->slug" : 'افزودن نقش'}}</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                {!! get_svg_icon('icons/duotune/arrows/arr061.svg','svg-icon svg-icon-1') !!}
                <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-lg-5 my-7">
                <!--begin::Form-->
                <form class="form">
                    <!--begin::Scroll-->
                    <div wire:ingore.self class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_role_scroll"
                         data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_role_header"
                         data-kt-scroll-wrappers="#kt_modal_add_role_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        <div class="row mb-10">
                            <div class="col-12 col-lg-6">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">نام نقش (به انگلیسی)</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control @error('role.name') is-invalid @enderror form-control-solid"
                                       wire:model.lazy="role.name"/>
                                @error('role.name')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                            <!--end::Input-->
                            </div>
                            <div class="col-12 col-lg-6">
                                <!--begin::Label-->
                                <label class="fs-5 fw-bold form-label mb-2">
                                    <span class="required">عنوان نقش</span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control @error('role.slug') is-invalid @enderror form-control-solid"
                                       wire:model.lazy="role.slug"/>
                                @error('role.slug')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                            <!--end::Input-->
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Permissions-->
                        <div class="fv-row">
                            <!--begin::Label-->
                            <label class="fs-5 fw-bold form-label mb-2">دسترسی ها</label>
                            <!--end::Label-->
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <!--begin::Table body-->
                                    <tbody class="text-gray-600 fw-semibold">
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">مدیریت نمایندگان</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex justify-content-between">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="create-agent"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">افزودن نماینده</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="view-agent-table"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">لیست نمایندگان</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="edit-agent"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">ویرایش نماینده</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="delete-agent"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">حذف نماینده</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800"></td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex justify-content-between">
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="deactivate-agent"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">فعال/غیرفعال کردن</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="view-user-log"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">لاگ های نماینده</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="view-agent-references"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">زیر مجموعه نماینده</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="view-agent-tickets"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">تیکت های نماینده</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800"></td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex justify-content-between">
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="view-agent-overview"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">تب جزییات</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="view-agent-clients"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">تب مشتریان</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="view-agent-financial"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">تب مالی</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="view-agent-plans"
                                                           wire:model.defer="permissions"/>
                                                    <span class="formview-agent-security-check-label">تب طرح های</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="view-agent-security"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">تب امنیت</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">مدیریت مشتریان</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex justify-content-between">
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="view-client-overview" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">مشاهده جزییات مشتریان</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="view-client-subscriptions" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">مشاهده اشتراک مشتریان</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="view-client-financial" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">مشاهده تب مالی مشتریان</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="change-client-layer" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">تغییر لایه</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="deactivate-client" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">فعال/غیرفعال کردن</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="delete-client" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">حذف مشتری</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">مدیریت تخفیف ها</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex justify-content-between">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="modify-discount" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">تعریف تخفیف</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="view-discount" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">مشاهده تخفیف ها</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="delete-discount" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">حذف تخفیف</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="view-discount-table" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">مشاهده لیست تخفیف ها</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">مدیریت طرح ها</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex justify-content-between">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="modify-plan"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">تعریف طرح</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="view-plans-table"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">مشاهده طرح ها</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="buy-plan"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">خرید طرح</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="delete-plan"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">حذف طرح</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">مدیریت لایه ها</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex justify-content-between">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="modify-layer"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">تعریف لایه</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="view-layer"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">مشاهده لایه</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="view-layer-table"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">مشاهده لیست لایه ها</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="delete-layer"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">حذف لایه</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">مدیریت سرور ها</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex justify-content-between">
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="modify-server" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">تعریف سرور</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="view-server-table"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">لیست سرور ها</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="view-server"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">جزییات سرور</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="view-server"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">جزییات سرور</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="delete-server" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">حذف سرور</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="change-server-layer" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">تغییر لایه</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">مدیریت دامنه ها</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex justify-content-between">
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="modify-domain" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">تعریف دامنه</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="view-domain-table"
                                                           wire:model.defer="permissions"/>
                                                    <span class="form-check-label">لیست دامنه ها</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="delete-domain" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">حذف دامنه</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">مدیریت مالی</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex justify-content-between">
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="reverse-invoice" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">برگشت فاکتور</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="view-invoice" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">جزییات فاکتور</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="view-invoice-table" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">لیست فاکتورها</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="view-payment-table" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">لیست پرداختی ها</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="view-transaction-table" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">لیست تراکنش ها</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">مدیریت تیکت ها</td>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div class="d-flex justify-content-between">
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="submit-ticket-for-user" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">ثبت تیکت برای کاربران</span>
                                                </label>
                                                <!--end::Checkbox-->
                                                <!--begin::Checkbox-->
                                                <label
                                                        class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                           value="toggle-ticket-status" wire:model.defer="permissions"/>
                                                    <span class="form-check-label">تغییر وضعیت تیکت</span>
                                                </label>
                                                <!--end::Checkbox-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Options-->
                                    </tr>
                                    <!--end::Table row-->
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
                        </div>
                        <!--end::Permissions-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">انصراف
                        </button>
                        <button wire:loading.attr="disabled" wire:target="create" wire:click.prevent="create()" class="btn btn-primary">

                            <!--begin::Indicator-->
                            <span class="indicator-label" wire:target="create" wire:loading.class="d-none">
   {{$editMode ? 'ویرایش نقش' :'ایجاد نقش'}}
</span>
                            <span class="indicator-progress" wire:target="create"
                                  wire:loading.class="d-block">
    در حال پردازش
    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
</span>
                            <!--end::Indicator-->
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
@push('scripts')
    <script>
        const roleModal = document.getElementById('add_role')
        roleModal.addEventListener('hidden.bs.modal', event => {
        @this.resetModal();
        });

        function editRole(id)
        {
        @this.emit('editRole', id);
        }

        document.addEventListener('toggleRoleModal', function () {
            $('#add_role').modal('toggle');
        });
    </script>
@endpush

