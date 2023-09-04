<?php
use App\Core\Extensions\Google2FA;
$google2FA = new Google2FA();
?>
<div wire:ignore.self class="modal fade" id="kt_modal_add_ask_google2fa_code" tabindex="-1" aria-hidden="true"
     xmlns:wire="http://www.w3.org/1999/xhtml">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">{{__('messages.Two Factor Authentication')}}</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <?= get_svg_icon('icons/duotone/Navigation/Close.svg') ?>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-lg-15 mb-7">
                @if(!$showRecoveryPhrase)
            @if($user->getData('2fa_enabled'))
              <div wire:key="{{\Illuminate\Support\Str::random(12)}}">
                  <!--begin::Input group-->
                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class="fs-6 fw-bold form-label mb-2">
                        <span
                            class="required">{{__('messages.One-time Code')}}</span>
                          <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                             data-bs-trigger="hover"
                             data-bs-html="true"
                             data-bs-content="{{__('messages.Enter the one-time code received from the app')}}"></i>
                      </label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <input wire:model.lazy="code" class="@error('code') is-invalid @enderror form-control form-control-solid" name="code"/>
                      @error('code')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <!--end::Input-->
                  </div>
                  <!--end::Input group-->
                  <!--begin::Actions-->
                  <div class="text-center pt-15">
                      <button type="button" class="btn btn-primary" wire:click="disable2fa"> {{__('messages.Deactivate')}} </button>
                  </div>
                  <!--end::Actions-->
              </div>
            @else
               <div wire:key="{{\Illuminate\Support\Str::random(12)}}">
                   <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-10 p-6">
                       <!--begin::Icon-->
                       <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                   {!! get_svg_icon('icons/duotune/general/gen045.svg','svg-icon svg-icon-2tx svg-icon-primary me-4') !!}
                   <!--end::Svg Icon-->
                       <!--end::Icon-->
                       <!--begin::Wrapper-->
                       <div class="d-flex flex-stack flex-grow-1">
                           <!--begin::Content-->
                           <div class="fw-semibold">
                               <div class="fs-6 text-gray-700 fw-semibold">شما میتوانید از اپلیکیشن هایی مانند <a href="https://support.google.com/accounts/answer/1066447?hl=en" target="_blank">Google Authenticator</a>،
                                   <a href="https://www.microsoft.com/en-us/account/authenticator">Microsoft Authenticator</a>،
                                   <a href="https://authy.com/download/">Authy</a> یا ،<a href="https://support.1password.com/one-time-passwords/">1Password</a>, استفاده کنید و سپس عکس زیر را اسکن کنید. سپس کد 6 رقمی داده شده را وارد کنید</div>
                           </div>
                           <!--end::Content-->
                       </div>
                       <!--end::Wrapper-->
                   </div>
                   @php
                   $qrCodeUrl = $google2FA->getQRCodeUrl(env('APP_NAME'), $user->username, $secret);
                   @endphp
                   <!--begin::Input group-->
                   <div class="d-flex flex-column flex-center">
                       <img
                           src="https://chart.googleapis.com/chart?cht=qr&chs=360x360&chl={{$qrCodeUrl}}"
                           alt="{{__('messages.QR Code')}}"
                           class="w-25 rounded border-1 border-dashed">
                       <span class="d-none" id="secret">{{$secret}}</span>
                       <button class="btn btn-sm btn-primary mt-2" onclick="copyToClipboard('secret')">کپی</button>
                   </div>
                   <div class="separator border-1 border-dashed my-10"></div>
                   <div class="fv-row mb-7">
                       <!--begin::Label-->
                       <label class="fs-6 fw-bold form-label mb-2">
                        <span
                            class="required">{{__('messages.One-time Code')}}</span>
                           <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover"
                              data-bs-trigger="hover"
                              data-bs-html="true"
                              data-bs-content="{{__('messages.Scan the image above with the Google Authenticator software and enter the received code')}}"></i>
                       </label>
                       <!--end::Label-->
                       <!--begin::Input-->
                       <input wire:model.lazy="code" class="@error('code') is-invalid @enderror form-control form-control-solid mt-2 mb-3" name="code"/>
                       @error('code')
                       <div class="invalid-feedback">{{ $message }}</div>
                   @enderror
                   <!--end::Input-->
                   </div>
                   <!--end::Input group-->
                   <!--begin::Actions-->
                   <div class="text-center pt-15">
                       <button type="button" class="btn btn-primary" wire:click="enable2fa"> {{__('messages.Activate')}} </button>
                   </div>
                   <!--end::Actions-->
               </div>
                @endif
                    @else
                        <div wire:key="{{\Illuminate\Support\Str::random(12)}}" class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-10 p-6">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                        {!! get_svg_icon('icons/duotune/general/gen045.svg','svg-icon svg-icon-2tx svg-icon-primary me-4') !!}
                        <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-grow-1">
                                <!--begin::Content-->
                                <div class="fw-semibold">
                                    <div class="fs-6 text-dark fw-semibold">لطفا کد پشتیبان را دریافت و در محلی امن ذخیره یا یادداشت نمایید</div>
                                    <div class="fs-6 text-dark fw-semibold">در مواقعی که به دستگاه خود دسترسی ندارید، میتوانید با وارد کردن یکی از کد های پشتیبان به حساب خود دسترسی داشته باشید</div>
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--begin::Input group-->

                        <div class="fv-row mb-7 d-flex flex-center">
                            <a wire:click.prevent="downloadRecoveryPhrase()" class="btn btn-lg btn-primary"><i class="fa fa-file-download fs-3 me-2"></i> دریافت </a>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> بستن </button>
                        </div>
                        <!--end::Actions-->
                @endif
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
@push('scripts')
    <script>
        const modal = document.getElementById('kt_modal_add_ask_google2fa_code')
        modal.addEventListener('hidden.bs.modal', event => {
        @this.resetModal();
        });

        document.addEventListener('toggle-kt_modal_add_ask_google2fa_code', function () {
            $('#kt_modal_add_ask_google2fa_code').modal('toggle');
        });
    </script>
@endpush
