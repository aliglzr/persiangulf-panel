<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
         data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">وضعیت حساب</h3>
        </div>
    </div>
    <!--end::Card header-->
    <!--begin::Content-->
    <div id="kt_account_settings_deactivate" class="collapse show">
        <!--begin::Form-->
        <div class="form fv-plugins-bootstrap5 fv-plugins-framework">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                <!--begin::Notice-->
                <div class="notice d-flex bg-light-{{$user->active ? 'primary' : 'danger'}} rounded border-{{$user->active ? 'primary' : 'danger'}} border border-dashed mb-9 p-6">
                    <!--begin::Icon-->
                    <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                @if($user->active)
                    {!! get_svg_icon('icons/duotune/general/gen026.svg','svg-icon svg-icon-2tx svg-icon-primary me-4') !!}
                @else
                    {!! get_svg_icon('icons/duotune/general/gen047.svg','svg-icon svg-icon-2tx svg-icon-danger me-4') !!}
                @endif
                <!--end::Svg Icon-->
                    <!--end::Icon-->
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-grow-1">
                        <!--begin::Content-->
                        <div class="fw-semibold">
                            <h4 class="text-gray-900 fw-bold">{{$user->active ? 'فعال' : 'غیر فعال'}}</h4>
                            <div class="fs-6 text-gray-700">آخرین ورود :
                                <br>
                                <div class=" {{(theme()->isDarkModeEnabled() && theme()->getCurrentMode() !== 'light') ? 'text-white' : 'text-dark' }} ">{{$user->getData('last_login') ? \App\Core\Extensions\Verta\Verta::enToFaNumbers(\Hekmatinasser\Verta\Verta::instance($user->getData('last_login'))->format('H:i:s Y-m-d')) : 'کاربر تابحال وارد حساب خود نشده است'}}</div>
                            @if(!$user->active)
                                <br>
                                <div class="d-block">
                                        علت :
                                </div>
                                    <p class="{{(theme()->isDarkModeEnabled() && theme()->getCurrentMode() !== 'light') ? 'text-white' : 'text-dark' }}">{{$user->getData('deactivation_reason')}}</p>
                                @endif
                            </div>
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Notice-->
            </div>
            <!--end::Card body-->
            <!--begin::Card footer-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button wire:click.prevent="toggleActivation()" wire:target="toggleActivation" wire:loading.attr="disabled" class="btn btn-primary fw-semibold {{!$user->active ? '' : 'd-none'}}">
                                     <span class="indicator-label" wire:target="toggleActivation" wire:loading.class="d-none" >
 فعال سازی حساب
               </span>
                        <span class="indicator-progress" wire:target="toggleActivation" wire:loading.class="d-block">
                        در حال فعال سازی
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
</span>
                    </button>
                    <button id="kt_account_deactivate_account_submit" class="btn btn-danger fw-semibold {{!$user->active ? 'd-none' : ''}}"
                            data-bs-toggle="modal" data-bs-target="#toggle_activation_reason_modal">غیر فعال سازی حساب
                    </button>
            </div>
            <!--end::Card footer-->
            <input type="hidden"></div>
        <!--end::Form-->
    </div>
    <!--end::Content-->

    <div wire:ignore.self class="modal fade" tabindex="-1" id="toggle_activation_reason_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-danger">شما در حال غیر فعال سازی این حساب هستید</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <span class="svg-icon svg-icon-1"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <label for="password"
                           class=" col-lg-4 col-form-label fs-6 fw-bolder">دلیل غیر فعال سازی</label>
                    <textarea wire:model.lazy="reason" class="form-control @error('reason') is-invalid @enderror"></textarea>
                    @error('reason')
                    <div class="invalid-feedback" role="alert">{{$message}}</div>
                    @enderror
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" wire:target="toggleActivation" wire:loading.attr="disabled" data-bs-dismiss="modal">انصراف</button>
                    <button wire:click.prevent="toggleActivation()" wire:target="toggleActivation" wire:loading.attr="disabled" class="btn btn-danger" id="kt_account_profile_details_submit">
               <span class="indicator-label" wire:target="toggleActivation" wire:loading.class="d-none" >
 تایید
               </span>
                        <span class="indicator-progress" wire:target="toggleActivation" wire:loading.class="d-block">
                        در حال پردازش
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        document.addEventListener('closeModal',function () {
            $('#toggle_activation_reason_modal').modal('hide');
        })
    </script>
@endpush
