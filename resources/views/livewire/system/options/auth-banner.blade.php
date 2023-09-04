<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">تصویر صفحه ورود</h3>
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
                    <label for="auth_page_title" class="col-lg-4 col-form-label fw-semibold fs-6">عنوان</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="auth_page_title" type="text" wire:model.lazy="auth_page_title"
                               class="form-control @error('auth_page_title') is-invalid @enderror form-control-lg form-control-solid">
                        @error('auth_page_title')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="auth_page_subtitle" class="col-lg-4 col-form-label fw-semibold fs-6">توضیحات</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="auth_page_subtitle" type="text" wire:model.lazy="auth_page_subtitle"
                               class="form-control @error('auth_page_subtitle') is-invalid @enderror form-control-lg form-control-solid">
                        @error('auth_page_subtitle')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="attachment"
                           class="col-lg-4 col-form-label fw-semibold fs-6">پیوست</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                    <input id="attachment"
                           class="mb-2 form-control @error('attachment') is-invalid @enderror form-control-solid"
                           wire:model="attachment" type="file"/>
                    @error('attachment')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <!--end::Input-->

                    <div class="d-flex" wire:loading.class="d-none" wire:target="attachment">
                        <div class="text-primary fw-semibold">پسوند های مجاز:</div>
                        <div class="mx-2"></div>
                        <div>jpg, jpeg, png, svg</div>
                    </div>
                    <!--begin::Progress-->
                    <div id="attachment_progress_parent" class="progress h-8px bg-light-primary mt-5 d-none"
                         wire:loading.class.remove="d-none" wire:target="attachment">
                        <div id="attachment_progress" class="progress-bar bg-primary" role="progressbar" style="width: 0%"
                             aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <!--end::Progress-->
                    <div>
                           <span wire:loading.class="d-block" wire:target="attachment"
                                 class="indicator-progress mt-2">{{__('messages.Uploading')}}
															<span id="progress_number"
                                                                  class="align-middle ms-2">%0</span></span>
                    </div>
                    </div>
                </div>



            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button class="btn btn-primary" wire:click.prevent="save()">ذخیره</button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
</div>
@push('scripts')
<script>
    document.addEventListener('livewire:load',function () {
        $('#attachment').on('livewire-upload-start', function () {
            $('#attachment_progress').css('width', '0%');
            $('#progress_number').text('%0');
        });

        $('#attachment').on('livewire-upload-finish', function () {
            $('#attachment_progress').css('width', '0%');
            $('#progress_number').text('%0');
        });

        $('#attachment').on('livewire-upload-progress', function (event) {
            $('#attachment_progress').css('width', event.detail.progress + '%');
            $('#progress_number').text('%' + event.detail.progress);
        });
    })
</script>
@endpush
