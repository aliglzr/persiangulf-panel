<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
         data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">حذف حساب کاربری</h3>
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
                <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed mb-9 p-6">
                    <!--begin::Icon-->
                    <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                    {!! get_svg_icon('icons/duotune/general/gen044.svg','svg-icon svg-icon-2tx svg-icon-danger me-4') !!}
                <!--end::Svg Icon-->
                    <!--end::Icon-->
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-grow-1">
                        <!--begin::Content-->
                        <div class="fw-semibold">
                            <h4 class="text-gray-900 fw-bold">توجه :</h4>
                            @if($user->isClient())
                                <div class="text-dark fs-6">در صورت حذف ،امکان برگشت عملیات وجود نخواهد داشت و مشتری برای همیشه حذف خواهد شد. همچنین درصورتی که مشتری از اشتراک خود استفاده نکرده باشد، اشتراک به طرح شما بازگردانده خواهد شد.</div>
                            @else
                                <div class="text-dark fs-6">در صورت حذف کاربر ، تمامی اطلاعات کاربر حذف و مشترکان این کاربر، به معرف این نماینده مرتبط خواهند شد</div>
                            @endif
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Notice-->
                <!--begin::Form input row-->
            {{--                <div class="form-check form-check-solid fv-row fv-plugins-icon-container">--}}
            {{--                    <input wire:model.lazy="confirmation" class="form-check-input" type="checkbox" value=""--}}
            {{--                           id="confirmation">--}}
            {{--                    <label class="form-check-label fw-semibold ps-2 fs-6"--}}
            {{--                           for="confirmation">{{$user->active ? 'غیر' : ''}} فعال سازی این حساب را تایید میکنم</label>--}}
            {{--                    <div class="fv-plugins-message-container invalid-feedback"></div>--}}
            {{--                </div>--}}
            <!--end::Form input row-->
            </div>
            <!--end::Card body-->
            <!--begin::Card footer-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button id="kt_account_deactivate_account_submit" class="btn btn-danger fw-semibold"
                            data-bs-toggle="modal" data-bs-target="#delete_user_modal">حذف این حساب
                    </button>
            </div>
            <!--end::Card footer-->
            <input type="hidden"></div>
        <!--end::Form-->
    </div>
    <!--end::Content-->

    <div wire:ignore.self class="modal fade" tabindex="-1" id="delete_user_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-gray-900">شما در حال حذف حساب کاربری <span class="text-primary fw-bolder">{{$user->username}}</span> هستید</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <span class="svg-icon svg-icon-1"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <label for="password"
                           class=" col-lg-4 col-form-label fs-6 fw-bolder">دلیل حذف کاربر</label>
                    <textarea wire:model.lazy="reason" class="form-control @error('reason') is-invalid @enderror"></textarea>
                    @error('reason')
                    <div class="invalid-feedback" role="alert">{{$message}}</div>
                    @enderror

                    <label for="delete_user"
                           class=" col-lg-4 col-form-label fs-6 fw-bolder">تایپ عبارت delete user</label>
                    <input wire:model.lazy="delete_user" class="form-control @error('delete_user') is-invalid @enderror">
                    <small class="text-muted fw-bold">جهت حذف کاربر عبارت <span class="text-danger fw-bolder">delete user</span> را تایپ کنید</small>
                    @error('delete_user')
                    <div class="invalid-feedback" role="alert">{{$message}}</div>
                    @enderror

                </div>


                <div class="modal-footer {{$deleted ? 'd-none' : ''}}">
                    <button type="button" class="btn btn-primary" wire:target="deleteUser" wire:loading.attr="disabled" data-bs-dismiss="modal">انصراف</button>
                    <button wire:click.prevent="deleteUser()" wire:target="deleteUser" wire:loading.attr="disabled" class="btn btn-danger" id="kt_account_profile_details_submit">
               <span class="indicator-label" wire:target="deleteUser" wire:loading.class="d-none" >
 حذف کاربر
               </span>
                        <span class="indicator-progress" wire:target="deleteUser" wire:loading.class="d-block">
                        در حال حذف
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
            $('#delete_user_modal').modal('hide');
        })
    </script>
@endpush
