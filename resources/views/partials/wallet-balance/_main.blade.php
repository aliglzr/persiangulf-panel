<!--begin::Menu toggle-->
<a href="#" class="btn btn-custom btn-icon-muted btn-active-light btn-active-color-primary h-35px h-md-40px px-3" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
    <div class="d-flex justify-content-between align-items-center flex-nowrap">
        <div>
            <i class="fa fa-wallet fs-4 mx-2"></i>
        </div>
        <livewire:layout.topbar.balance />
{{--        <div>--}}
{{--            <!--begin::Svg Icon | path: icons/duotune/general/gen060.svg-->--}}
{{--        {!! get_svg_icon('icons/duotune/finance/fin002.svg','svg-icon theme-light-show svg-icon-2') !!}--}}
{{--        <!--end::Svg Icon-->--}}
{{--            <!--begin::Svg Icon | path: icons/duotune/general/gen061.svg-->--}}
{{--        {!! get_svg_icon('icons/duotune/finance/fin002.svg','svg-icon theme-dark-show svg-icon-2') !!}--}}
{{--        <!--end::Svg Icon-->--}}
{{--        </div>--}}
    </div>
</a>
<!--begin::Menu toggle-->
{{ theme()->getView('partials/wallet-balance/__menu') }}
