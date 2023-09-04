<x-base-layout>

    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Sidebar-->
        <div class="d-none d-lg-flex flex-column flex-lg-row-auto w-100 w-lg-275px" data-kt-drawer="true" data-kt-drawer-name="inbox-aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_inbox_aside_toggle">
            <!--begin::Sticky aside-->
            <div class="card card-flush mb-0" data-kt-sticky="false" data-kt-sticky-name="inbox-aside-sticky" data-kt-sticky-offset="{default: false, xl: '100px'}" data-kt-sticky-width="{lg: '275px'}" data-kt-sticky-left="auto" data-kt-sticky-top="100px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
                <!--begin::Aside content-->
                <div class="card-body">
                    <!--begin::Button-->
                    <h2 class="fw-bold w-100 mb-8">جزییات ایمیل</h2>
                    <!--end::Button-->
                    <div class="mb-7">
                        <!--begin::Label-->
                        <label class="fw-semibold text-muted">نام</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div>
                            <span class="fw-bold fs-6 text-gray-800">{{$resource['name']}}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="mb-7">
                        <!--begin::Label-->
                        <label class="fw-semibold text-muted">Namespace (فضای نام)</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div>
                            <span dir="ltr" class="fw-bold fs-6 text-gray-800">{{$resource['namespace']}}</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="mb-7">
                        <!--begin::Label-->
                        <label class="fw-semibold text-muted">عنوان ایمیل</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div>
                            <span class="fw-bold fs-6 text-gray-800">{!! $resource['subject'] != $resource['namespace'] ? 'عنوانی تنظیم نشده است. از فضای نام پیشفرض به عنوان ایمیل استفاده میشود. جهت تغییر <a class="d-inline-block" href="https://laravel.com/docs/9.x/notifications#customizing-the-subject">اینجا</a> را مطالعه کنید.' : $resource['subject'] !!}</span>
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="mb-7">
                        <!--begin::Label-->
                        <label class="fw-semibold text-muted">آدرس ارسال کننده</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div>
                            <a href="mailto:{{env('MAIL_FROM_ADDRESS','default')}}" class="badge badge-light-primary">{{env('MAIL_FROM_ADDRESS','default')}}</a>
                        </div>
                        <!--end::Col-->
                    </div>

                </div>
                <!--end::Aside content-->
            </div>
            <!--end::Sticky aside-->
        </div>
        <!--end::Sidebar-->
        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header align-items-center py-5 gap-5">
                    <!--begin::Actions-->
                    <div class="d-flex">
                        <!--begin::Back-->
                        <a href="{{route('mailables.index')}}" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="برگشت" aria-label="Back">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr063.svg-->
                           {!! get_svg_icon('icons/duotune/arrows/arr064.svg','svg-icon svg-icon-1 m-0') !!}
                            <!--end::Svg Icon-->
                        </a>
                        <!--end::Back-->
                        <!--begin::Send-->
                        <a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2" data-bs-toggle="modal" data-bs-target="#sendTestMail"  title="ارسال ایمیل تست">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com010.svg-->
                            {!! get_svg_icon('icons/duotune/communication/com010.svg','svg-icon svg-icon-2 m-0') !!}
                            <!--end::Svg Icon-->
                        </a>
                        <!--end::Send-->

                        <!--begin::Edit-->
                        <a href="{{route('mailables.template.edit',['name' => $resource['name']])}}" class="btn btn-sm btn-icon btn-light btn-active-light-primary me-2" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit" title="ویرایش قالب ایمیل">
                            <!--begin::Svg Icon | path: icons/duotune/communication/com010.svg-->
                            <i class="fa fa-edit"></i>
{{--                        {!! get_svg_icon('icons/duotune/communication/com010.svg','svg-icon svg-icon-2 m-0') !!}--}}
                        <!--end::Svg Edit-->
                        </a>
                        <!--end::Send-->
                    </div>
                    <!--end::Actions-->
                </div>
                <div class="card-body">
                    @include($resource['data']->view)
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content-->
    </div>



    <livewire:mail.send-test-mail-modal :name="$name" />

</x-base-layout>



