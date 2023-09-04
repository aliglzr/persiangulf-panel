<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
         data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">{{auth()->user()->id == $user->id ? 'برداشت از حساب' : 'انتقال اعتبار به حساب نماینده'}}</h3>
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
                    {!! get_svg_icon('icons/duotune/finance/fin010.svg','svg-icon svg-icon-2tx svg-icon-primary me-4') !!}
                <!--end::Svg Icon-->
                    <!--end::Icon-->
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-grow-1">
                        <!--begin::Content-->
                        <div class="fw-semibold">
                            <div class="fs-6 text-gray-700">موجودی قابل برداشت :
                                <br>
                                <div class=" {{(theme()->isDarkModeEnabled() && theme()->getCurrentMode() !== 'light') ? 'text-white' : 'text-dark' }} ">{{convertNumbers(number_format($user->getData('wallet_balance') ?? 0))}} تومان </div>
                            </div>
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
                    <button id="toggle_confirmation_alert" class="btn btn-primary fw-semibold">
                       برداشت از حساب
                    </button>
            </div>
            <!--end::Card footer-->
            <input type="hidden"></div>
        <!--end::Form-->
    </div>
    <!--end::Content-->

</div>

@push('scripts')
    <script>
        $('#toggle_confirmation_alert').on('click',function (e) {
            Swal.fire({
                text: "آیا از برداشت خود اطمینان دارید؟",
                icon: "question",
                buttonsStyling: false,
                confirmButtonText: "بله",
                cancelButtonText: "خیر",
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-danger"
                }
            }).then(result => {
                if (result.isConfirmed){
                    @this.submit();
                }
            });
        });
    </script>
@endpush
