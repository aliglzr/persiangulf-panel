<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">لینک آموزش ها</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->
    <!--begin::Content-->
    <div class="collapse show">
        <!--begin::Form-->
        <form class="form fv-plugins-bootstrap5 fv-plugins-framework">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="tutorial_link" class="col-lg-4 col-form-label fw-semibold fs-6">لینک صفحه آموزش</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="tutorial_link" type="text" wire:model.lazy="tutorial_link"
                               class="form-control @error('tutorial_link') is-invalid @enderror form-control-lg form-control-solid">
                        @error('tutorial_link')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="android_tutorial_route" class="col-lg-4 col-form-label fw-semibold fs-6">آموزش اتصال در اندروید</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="android_tutorial_route" type="text" wire:model.lazy="android_tutorial_route"
                               class="form-control @error('android_tutorial_route') is-invalid @enderror form-control-lg form-control-solid">
                        @error('android_tutorial_route')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="ios_tutorial_route" class="col-lg-4 col-form-label fw-semibold fs-6">آموزش اتصال در IOS</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="ios_tutorial_route" type="text" wire:model.lazy="ios_tutorial_route"
                               class="form-control @error('ios_tutorial_route') is-invalid @enderror form-control-lg form-control-solid">
                        @error('ios_tutorial_route')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="mac_os_tutorial_route" class="col-lg-4 col-form-label fw-semibold fs-6">آموزش اتصال در MAC OS</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="mac_os_tutorial_route" type="text" wire:model.lazy="mac_os_tutorial_route"
                               class="form-control @error('mac_os_tutorial_route') is-invalid @enderror form-control-lg form-control-solid">
                        @error('mac_os_tutorial_route')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->


                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="windows_tutorial_route" class="col-lg-4 col-form-label fw-semibold fs-6">آموزش اتصال در ویندوز</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="windows_tutorial_route" type="text" wire:model.lazy="windows_tutorial_route"
                               class="form-control @error('windows_tutorial_route') is-invalid @enderror form-control-lg form-control-solid">
                        @error('windows_tutorial_route')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="linux_tutorial_route" class="col-lg-4 col-form-label fw-semibold fs-6">آموزش اتصال در لینوکس</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="linux_tutorial_route" type="text" wire:model.lazy="linux_tutorial_route"
                               class="form-control @error('linux_tutorial_route') is-invalid @enderror form-control-lg form-control-solid">
                        @error('linux_tutorial_route')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="about_us_route" class="col-lg-4 col-form-label fw-semibold fs-6">لینک درباره ما</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="about_us_route" type="text" wire:model.lazy="about_us_route"
                               class="form-control @error('about_us_route') is-invalid @enderror form-control-lg form-control-solid">
                        @error('about_us_route')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="download_android_application_direct_route" class="col-lg-4 col-form-label fw-semibold fs-6">لینک دانلود مستقیم اپلیکیشن اندروید</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="download_android_application_direct_route" type="text" wire:model.lazy="download_android_application_direct_route"
                               class="form-control @error('download_android_application_direct_route') is-invalid @enderror form-control-lg form-control-solid">
                        @error('download_android_application_direct_route')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="download_android_application_play_store_route" class="col-lg-4 col-form-label fw-semibold fs-6">لینک دانلود از گوگل پلی اپلیکیشن اندروید</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="download_android_application_play_store_route" type="text" wire:model.lazy="download_android_application_play_store_route"
                               class="form-control @error('download_android_application_play_store_route') is-invalid @enderror form-control-lg form-control-solid">
                        @error('download_android_application_play_store_route')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div wire:click.prevent="save()" class="card-footer d-flex justify-content-end py-6 px-9">
                <button class="btn btn-primary">ذخیره</button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
</div>
