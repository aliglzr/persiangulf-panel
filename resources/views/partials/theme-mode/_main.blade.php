<!--begin::Menu toggle-->
<a href="#" class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px w-md-40px h-md-40px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">

    <!--begin::Svg Icon | path: icons/duotune/general/gen060.svg-->
    {!! get_svg_icon('icons/duotune/general/gen060.svg','svg-icon theme-light-show svg-icon-2') !!}
	<!--end::Svg Icon-->
	<!--begin::Svg Icon | path: icons/duotune/general/gen061.svg-->
    {!! get_svg_icon('icons/duotune/general/gen061.svg','svg-icon theme-dark-show svg-icon-2') !!}
	<!--end::Svg Icon-->
</a>
<!--begin::Menu toggle-->
{{ theme()->getView('partials/theme-mode/__menu') }}
