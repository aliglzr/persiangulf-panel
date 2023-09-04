<div>
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">تنظیمات ربات فروش</h3>
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
                        <label for="bot_token" class="col-lg-4 col-form-label fw-semibold fs-6">توکن</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input id="bot_token" type="text" wire:model.lazy="bot_token"
                                   placeholder="123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11"
                                   class="form-control @error('bot_token') is-invalid @enderror form-control-lg form-control-solid">
                            @error('bot_token')
                            <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label for="bot_username" class="col-lg-4 col-form-label fw-semibold fs-6">نام کاربری</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input id="bot_username" type="text" wire:model.lazy="bot_username" placeholder="بدون @"
                                   class="form-control @error('bot_username') is-invalid @enderror form-control-lg form-control-solid">
                            @error('bot_username')
                            <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label for="force_join" class="col-lg-4 col-form-label fw-semibold fs-6">عضویت اجباری</label>
                        <!--begin::Label-->
                        <!--begin::Label-->
                        <div class="col-lg-8 d-flex align-items-center">
                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                <input class="form-check-input w-45px h-30px" type="checkbox"
                                       wire:model.lazy="force_join" id="force_join">
                                <label class="form-check-label" for="force_join"></label>
                                @error('force_join')
                                <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <!--begin::Label-->
                    </div>
                    <!--end::Input group-->
                    @if($force_join)
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label for="force_join_channels" class="col-lg-4 col-form-label fw-semibold fs-6">کانال های عضویت
                                اجباری</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <div class="card card-bordered">
                                    <div class="card-header">
                                        <h3 class="card-title">لیست کانال ها</h3>
                                        <div class="card-toolbar">
                                            <button type="button" wire:click="addForceJoinChannel"
                                                    class="btn btn-sm btn-light btn-active-light-success">
                                                افزودن
                                            </button>
                                        </div>
                                    </div>
                                    @foreach($force_join_channels as $key => $force_join_channel)
                                        <div class="card-body">
                                            <div class="card card-bordered">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        کانال {{convertNumbers($force_join_channel['name'])}}</h3>
                                                    <div class="card-toolbar">
                                                        <button type="button"
                                                                wire:click="deleteForceJoinChannelItem({{$key}})"
                                                                class="btn btn-sm btn-light btn-active-light-danger">
                                                            حذف
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <!--begin::Label-->
                                                    <label for="force_join_channels.{{$key}}.name"
                                                           class="col-lg-4 col-form-label fw-semibold fs-6">نام</label>
                                                    <!--end::Label-->
                                                    <input id="force_join_channels.{{$key}}.name" type="text"
                                                           wire:model.lazy="force_join_channels.{{$key}}.name"
                                                           placeholder="نام کانال"
                                                           class="form-control @error('force_join_channels'.$key.'name') is-invalid @enderror form-control-lg form-control-solid">
                                                    @error('force_join_channels'.$key.'name')
                                                    <div
                                                        class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                    <!--begin::Label-->
                                                    <label for="force_join_channels.{{$key}}.id"
                                                           class="col-lg-4 col-form-label fw-semibold fs-6">آیدی</label>
                                                    <!--end::Label-->
                                                    <input id="force_join_channels.{{$key}}.id" type="text"
                                                           wire:model.lazy="force_join_channels.{{$key}}.id"
                                                           placeholder="نوشتاری یا عددی"
                                                           class="form-control @error('force_join_channels'.$key.'id') is-invalid @enderror form-control-lg form-control-solid">
                                                    @error('force_join_channels'.$key.'id')
                                                    <div
                                                        class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                    <!--begin::Label-->
                                                    <label for="force_join_channels.{{$key}}.join_link"
                                                           class="col-lg-4 col-form-label fw-semibold fs-6">لینک
                                                        عضویت</label>
                                                    <!--end::Label-->
                                                    <input id="force_join_channels.{{$key}}.join_link" type="text"
                                                           wire:model.lazy="force_join_channels.{{$key}}.join_link"
                                                           placeholder="https://t.me/OfficialSolidVPN"
                                                           class="form-control @error('force_join_channels'.$key.'join_link') is-invalid @enderror form-control-lg form-control-solid">
                                                    @error('force_join_channels'.$key.'join_link')
                                                    <div
                                                        class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label for="force_join_message" class="col-lg-4 col-form-label fw-semibold fs-6">متن پیام
                                عضویت اجباری</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <input id="force_join_message" type="text" wire:model.lazy="force_join_message"
                                       placeholder="برای کار با ربات باید ابتدا در کانال های زیر عضو شوید ..."
                                       class="form-control @error('force_join_message') is-invalid @enderror form-control-lg form-control-solid">
                                @error('force_join_message')
                                <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label for="start_message" class="col-lg-4 col-form-label fw-semibold fs-6">متن آغازین</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row fv-plugins-icon-container">
                                <textarea id="start_message" type="text" wire:model.lazy="start_message"
                                       placeholder="به ربات تلگرامی Solid VPN خوش آمدید..."
                                          class="form-control @error('start_message') is-invalid @enderror form-control-lg form-control-solid"></textarea>
                                @error('start_message')
                                <div class="fv-plugins-message-container invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                    @endif
                </div>
                <!--end::Card body-->
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button wire:click.prevent="save()" class="btn btn-primary">ذخیره</button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
</div>
@section('title')
    تنظیمات
@endsection
@section('description')
    تنظیمات ربات فروش
@endsection
