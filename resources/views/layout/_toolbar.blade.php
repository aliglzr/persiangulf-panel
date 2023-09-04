@php
    $pageTitleDisplay = (theme()->getOption('layout', 'page-title/display') && theme()->getOption('layout', 'header/left') !== 'page-title');
@endphp
@if(View::hasSection('actions'))
<!--begin::Toolbar-->
<div class="toolbar py-2" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="{{ theme()->printHtmlClasses('toolbar-container', false) }} d-flex align-items-center">
        @if ($pageTitleDisplay)
            <!--begin::Page title-->
            <div class="flex-grow-1 flex-shrink-0 me-5">
                {{ theme()->getView('layout/_page-title') }}
            </div>
            <!--end::Page title-->
        @endif

        <!--begin::Action group-->
        <div class="d-flex {{ $pageTitleDisplay ? 'align-items-center' : 'flex-stack flex-grow-1' }} flex-wrap">
            @yield('actions')
{{--            <!--begin::Wrapper-->--}}
{{--            <div class="flex-shrink-0 me-2">--}}
{{--                <ul class="nav">--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="#" class="nav-link btn btn-sm btn-color-muted btn-icon-muted btn-active-icon-primary btn-active-text-primary fw-bold fs-7 px-4 me-1">{!! theme()->getSvgIcon("icons/duotune/files/fil005.svg", "svg-icon-2x") !!}Primary</a>--}}
{{--                        <a class="nav-link btn btn-sm btn-color-muted btn-active-color-primary btn-active-light active fw-bold fs-7 px-4 me-1" data-bs-toggle="tab" href="#">Day</a>--}}
{{--                    </li>--}}

{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link btn btn-sm btn-color-muted btn-active-color-primary btn-active-light fw-bold fs-7 px-4 me-1" data-bs-toggle="tab" href="">Week</a>--}}
{{--                    </li>--}}

{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link btn btn-sm btn-color-muted btn-active-color-primary btn-active-light fw-bold fs-7 px-4" data-bs-toggle="tab" href="#">Year</a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--            <!--end::Wrapper-->--}}

{{--            <!--begin::Wrapper-->--}}
{{--            <div class="d-flex align-items-center">--}}
{{--                <!--begin::Actions-->--}}
{{--                <div class="d-flex align-items-center">--}}
{{--                    <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light btn-active-color-primary">--}}
{{--                        {!! theme()->getSvgIcon("icons/duotune/files/fil005.svg", "svg-icon-2x") !!}--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <!--end::Actions-->--}}
{{--            </div>--}}
{{--            <!--end::Wrapper-->--}}
        </div>
        <!--end::Action group-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->
@endif
