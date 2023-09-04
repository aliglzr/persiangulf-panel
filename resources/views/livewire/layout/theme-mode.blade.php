<div>
    <!--begin::Menu toggle-->
    <a href="#"
       class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px w-md-40px h-md-40px"
       data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent"
       data-kt-menu-placement="bottom-end">

        <!--begin::Svg Icon | path: icons/duotune/general/gen060.svg-->
    {!! get_svg_icon('icons/duotune/general/gen060.svg','svg-icon theme-light-show svg-icon-2') !!}
    <!--end::Svg Icon-->
        <!--begin::Svg Icon | path: icons/duotune/general/gen061.svg-->
    {!! get_svg_icon('icons/duotune/general/gen061.svg','svg-icon theme-dark-show svg-icon-2') !!}
    <!--end::Svg Icon-->
    </a>
    <!--begin::Menu toggle-->
    <!--begin::Menu-->
    <div
            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-color fw-semibold py-4 fs-base w-175px"
            data-kt-menu="true" data-kt-element="theme-mode-menu">
        <!--begin::Menu item-->
        <div class="menu-item px-3 my-0">
            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
			<span class="menu-icon" data-kt-element="icon">
				<!--begin::Svg Icon | path: icons/duotune/general/gen060.svg-->
				{!! get_svg_icon('icons/duotune/general/gen060.svg','svg-icon svg-icon-3') !!}
            <!--end::Svg Icon-->
			</span>
                <span class="menu-title">روشن</span>
            </a>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu item-->
        <div class="menu-item px-3 my-0">
            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
			<span class="menu-icon" data-kt-element="icon">
				<!--begin::Svg Icon | path: icons/duotune/general/gen061.svg-->
				{!! get_svg_icon('icons/duotune/general/gen061.svg','svg-icon svg-icon-3') !!}
            <!--end::Svg Icon-->
			</span>
                <span class="menu-title">تیره</span>
            </a>
        </div>
        <!--end::Menu item-->
        <!--begin::Menu item-->
        <div class="menu-item px-3 my-0">
            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
			<span class="menu-icon" data-kt-element="icon">
				<!--begin::Svg Icon | path: icons/duotune/general/gen062.svg-->
				{!! get_svg_icon('icons/duotune/general/gen062.svg','svg-icon svg-icon-3') !!}
            <!--end::Svg Icon-->
			</span>
                <span class="menu-title">خودکار</span>
            </a>
        </div>
        <!--end::Menu item-->
    </div>
    <!--end::Menu-->

</div>

@push('scripts')
    <script>
        document.addEventListener('themeChanged', function () {
        @this.emit('themeChanged', {
            'theme': document.documentElement.getAttribute('data-theme')
        });
        })
    </script>
@endpush
