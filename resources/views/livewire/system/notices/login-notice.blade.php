<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">اطلاعیه صفحه ورود/ثبت نام</h3>
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
                    <label for="login_title" class="col-lg-4 col-form-label fw-semibold fs-6">عنوان</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="login_title" type="text" wire:model.lazy="title"
                               class="form-control @error('title') is-invalid @enderror form-control-lg form-control-solid">
                        @error('title')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="login_body" class="col-lg-4 col-form-label fw-semibold fs-6">متن</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <textarea id="login_body" type="text" wire:model.lazy="body"
                                  class="form-control @error('body') is-invalid @enderror form-control-lg form-control-solid"></textarea>
                        @error('body')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="login_body" class="col-lg-4 col-form-label fw-semibold fs-6">آیکون</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <button class="btn btn-{{$color}} me-2 mt-2" wire:click.prevent="setIcon('icons/duotune/general/gen044.svg')">{!! get_svg_icon('icons/duotune/general/gen044.svg','svg-icon-2tx svg-icon') !!}</button>
                            <button class="btn btn-{{$color}} me-2 mt-2" wire:click.prevent="setIcon('icons/duotune/general/gen003.svg')">{!! get_svg_icon('icons/duotune/general/gen003.svg','svg-icon-2tx svg-icon') !!}</button>
                            <button class="btn btn-{{$color}} me-2 mt-2" wire:click.prevent="setIcon('icons/duotune/general/gen007.svg')">{!! get_svg_icon('icons/duotune/general/gen007.svg','svg-icon-2tx svg-icon') !!}</button>
                            <button class="btn btn-{{$color}} me-2 mt-2" wire:click.prevent="setIcon('icons/duotune/general/gen012.svg')">{!! get_svg_icon('icons/duotune/general/gen012.svg','svg-icon-2tx svg-icon') !!}</button>
                            <button class="btn btn-{{$color}} me-2 mt-2" wire:click.prevent="setIcon('icons/duotune/general/gen026.svg')">{!! get_svg_icon('icons/duotune/general/gen026.svg','svg-icon-2tx svg-icon') !!}</button>
                            <button class="btn btn-{{$color}} me-2 mt-2" wire:click.prevent="setIcon('icons/duotune/general/gen030.svg')">{!! get_svg_icon('icons/duotune/general/gen030.svg','svg-icon-2tx svg-icon') !!}</button>
                            <button class="btn btn-{{$color}} me-2 mt-2" wire:click.prevent="setIcon('icons/duotune/general/gen045.svg')">{!! get_svg_icon('icons/duotune/general/gen045.svg','svg-icon-2tx svg-icon') !!}</button>
                            <button class="btn btn-{{$color}} me-2 mt-2" wire:click.prevent="setIcon('icons/duotune/general/gen047.svg')">{!! get_svg_icon('icons/duotune/general/gen047.svg','svg-icon-2tx svg-icon') !!}</button>
                            <button class="btn btn-{{$color}} me-2 mt-2" wire:click.prevent="setIcon('icons/duotune/general/gen040.svg')">{!! get_svg_icon('icons/duotune/general/gen040.svg','svg-icon-2tx svg-icon') !!}</button>
                        @error('icon')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="login_color" class="col-lg-4 col-form-label fw-semibold fs-6">نوع اطلاعیه</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <select id="login_color" wire:model.lazy="color"
                                class="form-select @error('color') is-invalid @enderror form-select-lg form-select-solid text-{{$color}}">
                            <option value="primary" class="text-primary">primary</option>
                            <option value="info" class="text-info">info</option>
                            <option value="warning" class="text-warning">warning</option>
                            <option value="danger" class="text-danger">error</option>
                            <option value="success" class="text-success">success</option>
                            <option value="secondary" class="text-secondary">secondary</option>
                            <option value="dark" class="text-dark">dark/light (depends on theme)</option>
                        </select>
                        @error('color')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="login_color" class="col-lg-4 col-form-label fw-semibold fs-6">صفحه</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <select id="login_color" multiple wire:model.lazy="pages"
                                class="form-select @error('pages') is-invalid @enderror form-select-lg form-select-solid">
                            <option value="login">صفحه ورود</option>
                            <option value="register">صفحه ثبت نام</option>
                        </select>
                        @error('pages')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">دکمه</label>
                    <!--begin::Label-->
                    <!--begin::Label-->
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                            <input class="form-check-input w-45px h-30px" type="checkbox"
                                   wire:model.lazy="button" id="login_button">
                            <label class="form-check-label" for="login_button"></label>
                            @error('button')
                            <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <!--begin::Label-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="login_button_label" class="col-lg-4 col-form-label fw-semibold fs-6">متن دکمه</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="login_button_label" type="text" wire:model.lazy="button_label"
                               class="form-control @error('button_label') is-invalid @enderror form-control-lg form-control-solid">
                        @error('button_label')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="login_button_url" class="col-lg-4 col-form-label fw-semibold fs-6">لینک دکمه</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="login_button_url" type="text" wire:model.lazy="button_url"
                               class="form-control @error('button_url') is-invalid @enderror form-control-lg form-control-solid">
                        @error('button_url')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="login_class" class="col-lg-4 col-form-label fw-semibold fs-6">کلاس</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="login_class" type="text" wire:model.lazy="class"
                               class="form-control @error('class') is-invalid @enderror form-control-lg form-control-solid">
                        @error('class')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="login_icon_classes" class="col-lg-4 col-form-label fw-semibold fs-6">کلاس آیکون</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="login_icon_classes" type="text" wire:model.lazy="icon_classes"
                               class="form-control @error('icon_classes') is-invalid @enderror form-control-lg form-control-solid">
                        @error('icon_classes')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="login_padding" class="col-lg-4 col-form-label fw-semibold fs-6">پدینگ</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="login_padding" type="text" wire:model.lazy="padding"
                               class="form-control @error('padding') is-invalid @enderror form-control-lg form-control-solid">
                        @error('padding')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <div class="h3 my-5">پیش نمایش</div>
                @if(!empty($title) && !empty($body) && !empty($icon))
                    @include('partials.general._notice',['color' => $color,'icon' => $icon,'body' => $body, 'button' => $button,'button_label' => $button_label,'button_url' => $button_url,'class' => $class,'icon_classes' => $icon_classes,'padding' => $padding])
                    @else
                    <div>ابتدا عنوان، متن و ایکون را انتخاب کنید</div>
                @endif


            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button wire:click.prevent="clear()" class="btn btn-dark me-2">پاکسازی</button>
                <button wire:click.prevent="save()" class="btn btn-primary">ذخیره</button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
</div>
