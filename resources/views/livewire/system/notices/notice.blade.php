<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">اطلاعیه ها</h3>
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
                    <label for="notice_title" class="col-lg-4 col-form-label fw-semibold fs-6">عنوان</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="notice_title" type="text" wire:model.lazy="notice.title"
                               class="form-control @error('notice.title') is-invalid @enderror form-control-lg form-control-solid">
                        @error('notice.title')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="notice_body" class="col-lg-4 col-form-label fw-semibold fs-6">متن</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <textarea id="notice_body" type="text" wire:model.lazy="notice.body"
                                  class="form-control @error('notice.body') is-invalid @enderror form-control-lg form-control-solid"></textarea>
                        @error('notice.body')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">آیکون</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <button class="btn btn-{{$notice->color}} me-2 mt-2" wire:click.prevent="setIcon('icons/duotune/general/gen044.svg')">{!! get_svg_icon('icons/duotune/general/gen044.svg','svg-icon-2tx svg-icon') !!}</button>
                            <button class="btn btn-{{$notice->color}} me-2 mt-2" wire:click.prevent="setIcon('icons/duotune/general/gen003.svg')">{!! get_svg_icon('icons/duotune/general/gen003.svg','svg-icon-2tx svg-icon') !!}</button>
                            <button class="btn btn-{{$notice->color}} me-2 mt-2" wire:click.prevent="setIcon('icons/duotune/general/gen007.svg')">{!! get_svg_icon('icons/duotune/general/gen007.svg','svg-icon-2tx svg-icon') !!}</button>
                            <button class="btn btn-{{$notice->color}} me-2 mt-2" wire:click.prevent="setIcon('icons/duotune/general/gen012.svg')">{!! get_svg_icon('icons/duotune/general/gen012.svg','svg-icon-2tx svg-icon') !!}</button>
                            <button class="btn btn-{{$notice->color}} me-2 mt-2" wire:click.prevent="setIcon('icons/duotune/general/gen026.svg')">{!! get_svg_icon('icons/duotune/general/gen026.svg','svg-icon-2tx svg-icon') !!}</button>
                            <button class="btn btn-{{$notice->color}} me-2 mt-2" wire:click.prevent="setIcon('icons/duotune/general/gen030.svg')">{!! get_svg_icon('icons/duotune/general/gen030.svg','svg-icon-2tx svg-icon') !!}</button>
                            <button class="btn btn-{{$notice->color}} me-2 mt-2" wire:click.prevent="setIcon('icons/duotune/general/gen045.svg')">{!! get_svg_icon('icons/duotune/general/gen045.svg','svg-icon-2tx svg-icon') !!}</button>
                            <button class="btn btn-{{$notice->color}} me-2 mt-2" wire:click.prevent="setIcon('icons/duotune/general/gen047.svg')">{!! get_svg_icon('icons/duotune/general/gen047.svg','svg-icon-2tx svg-icon') !!}</button>
                            <button class="btn btn-{{$notice->color}} me-2 mt-2" wire:click.prevent="setIcon('icons/duotune/general/gen040.svg')">{!! get_svg_icon('icons/duotune/general/gen040.svg','svg-icon-2tx svg-icon') !!}</button>
                        @error('notice.icon')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="notice_color" class="col-lg-4 col-form-label fw-semibold fs-6">نوع اطلاعیه</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <select id="notice_color" wire:model.lazy="notice.color"
                                class="form-select @error('notice.color') is-invalid @enderror form-select-lg form-select-solid text-{{$notice->color}}">
                            <option value="primary" class="text-primary">primary</option>
                            <option value="info" class="text-info">info</option>
                            <option value="warning" class="text-warning">warning</option>
                            <option value="danger" class="text-danger">error</option>
                            <option value="success" class="text-success">success</option>
                            <option value="secondary" class="text-secondary">secondary</option>
                            <option value="dark" class="text-dark">dark/light (depends on theme)</option>
                        </select>
                        @error('notice.color')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="notice_roles" class="col-lg-4 col-form-label fw-semibold fs-6">نقش</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <select id="notice_roles" multiple wire:model.lazy="notice.roles"
                                class="form-select @error('notice.roles') is-invalid @enderror form-select-lg form-select-solid">
                            <option value="client">مشتری</option>
                            <option value="agent">نماینده</option>
                            <option value="manager">مدیریت</option>
                            <option value="support">پشتیبان</option>
                        </select>
                        @error('notice.roles')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                @if(empty($notice->roles) || in_array('client',$notice->roles))
                    <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label for="notice_layers" class="col-lg-4 col-form-label fw-semibold fs-6">لایه</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <select id="notice_layers" multiple wire:model.lazy="notice.layers"
                                        class="form-select @error('notice.layers') is-invalid @enderror form-select-lg form-select-solid">
                                    @foreach(\App\Models\Layer::all() as $layer)
                                        <option value="{{$layer->id}}">{{$layer->name}}</option>
                                    @endforeach
                                </select>
                                @error('notice.layers')
                                <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                @endif

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">دکمه</label>
                    <!--begin::Label-->
                    <!--begin::Label-->
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                            <input class="form-check-input w-45px h-30px" type="checkbox"
                                   wire:model.lazy="notice.button" id="notice_button">
                            <label class="form-check-label" for="notice_button"></label>
                            @error('notice.button')
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
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">وضعیت نمایش</label>
                    <!--begin::Label-->
                    <!--begin::Label-->
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                            <input class="form-check-input w-45px h-30px" type="checkbox"
                                   wire:model.lazy="notice.active" id="notice_active">
                            <label class="form-check-label" for="notice_button"></label>
                            @error('notice.active')
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
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">فقط برای مشتریان دارای اشتراک فعال</label>
                    <!--begin::Label-->
                    <!--begin::Label-->
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                            <input class="form-check-input w-45px h-30px" type="checkbox"
                                   wire:model.lazy="notice.have_sub" id="notice_have_sub">
                            <label class="form-check-label" for="notice_have_sub"></label>
                            @error('notice.have_sub')
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
                    <label for="notice_button_label" class="col-lg-4 col-form-label fw-semibold fs-6">متن دکمه</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="notice_button_label" type="text" wire:model.lazy="notice.button_label"
                               class="form-control @error('notice.button_label') is-invalid @enderror form-control-lg form-control-solid">
                        @error('notice.button_label')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="notice_button_url" class="col-lg-4 col-form-label fw-semibold fs-6">لینک دکمه</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="notice_button_url" type="text" wire:model.lazy="notice.button_url"
                               class="form-control @error('notice.button_url') is-invalid @enderror form-control-lg form-control-solid">
                        @error('notice.button_url')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="notice_button_modal_id" class="col-lg-4 col-form-label fw-semibold fs-6">آیدی مودال</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="notice_button_modal_id" type="text" wire:model.lazy="notice.button_modal_id"
                               class="form-control @error('notice.button_modal_id') is-invalid @enderror form-control-lg form-control-solid">
                        @error('notice.button_modal_id')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="notice_class" class="col-lg-4 col-form-label fw-semibold fs-6">کلاس</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="notice_class" type="text" wire:model.lazy="notice.class"
                               class="form-control @error('notice.class') is-invalid @enderror form-control-lg form-control-solid">
                        @error('notice.class')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="notice_icon_classes" class="col-lg-4 col-form-label fw-semibold fs-6">کلاس آیکون</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="notice_icon_classes" type="text" wire:model.lazy="notice.icon_classes"
                               class="form-control @error('notice.icon_classes') is-invalid @enderror form-control-lg form-control-solid">
                        @error('notice.icon_classes')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label for="notice_padding" class="col-lg-4 col-form-label fw-semibold fs-6">پدینگ</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <input id="notice_padding" type="text" wire:model.lazy="notice.padding"
                               class="form-control @error('notice.padding') is-invalid @enderror form-control-lg form-control-solid">
                        @error('notice.padding')
                        <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <div class="h3 my-5">پیش نمایش</div>
                @foreach($notices as $notice)
                    @php
                    /** @var \App\Models\Notice $notice */
                @endphp
                @if(!empty($notice->title) && !empty($notice->body) && !empty($notice->icon))
                    @include('partials.general._notice',['color' => $notice->color,'icon' => $notice->icon,'body' => $notice->body, 'button' => $notice->button,'button_label' => $notice->button_label,'button_url' => $notice->button_url,'button_modal_id' => $notice->button_modal_id,'class' => $notice->class,'icon_classes' => $notice->icon_classes,'padding' => $notice->padding,'editMode' => true,'id' => $notice->id])
                    @else
                    <div>ابتدا عنوان، متن و ایکون را انتخاب کنید</div>
                @endif
                @endforeach

            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button wire:click.prevent="resetForm()" class="btn btn-dark me-2">ریست</button>
                <button wire:click.prevent="save()" class="btn btn-primary">{{$editMode ? 'ویرایش' : 'ذخیره'}}</button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
</div>
