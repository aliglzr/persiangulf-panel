<!--begin::Aside-->
<div
	id="kt_aside"
	class="aside pb-5 pt-5 pt-lg-0 {{ theme()->printHtmlClasses('aside', false) }}"
	data-kt-drawer="true"
	data-kt-drawer-name="aside"
	data-kt-drawer-activate="{default: true, lg: false}"
	data-kt-drawer-overlay="true"
	data-kt-drawer-width="{default:'80px', '300px': '100px'}"
	data-kt-drawer-direction="start"
	data-kt-drawer-toggle="#kt_aside_mobile_toggle"
	>
    <!--begin::Brand-->
    <div class="d-flex flex-column aside-logo align-items-center py-8" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="{{ theme()->getPageUrl('') }}" class="img-logo d-flex align-items-center">
            <img alt="Logo" src="{{ asset(theme()->getMediaUrlPath() . 'logos/logo.svg') }}" class="h-45px logo"/>
        </a>
        <!--end::Logo-->

		<!--begin::Live DateTime-->
		<div class="text-logo d-flex align-items-md-center mt-6">
            <div class="fs-6">
               SolidVPN
            </div>
		</div>
		<!--end::Live DateTime-->

		<!--begin::Live DateTime-->
		<div class="d-flex align-items-md-center mt-4">
            <div class="text-date text-gray-700 fs-7">
               {{\App\Core\Extensions\Verta\Verta::now()->persianFormat("j F Y")}}
            </div>
		</div>
		<!--end::Live DateTime-->
	</div>
    <!--end::Brand-->

    <!--begin::Aside menu-->
	<div class="aside-menu flex-column-fluid" id="kt_aside_menu">
		{{ theme()->getView('layout/aside/_menu') }}
    </div>
    <!--end::Aside menu-->

</div>
<!--end::Aside-->

@push('styles')
	<style>
		.aside-logo {
			height: 160px !important;
			transition-duration: 0.1s !important;
			transition-timing-function: linear !important;
			transition-delay: 0.1s !important;
			-webkit-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}
		.text-logo {
			transition-duration: 0.1s !important;
			transition-timing-function: linear !important;
			transition-delay: 0.1s !important;
			font-family: Helvetica,serif !important;
			color: #999999 !important;
		}
		.text-date {
			transition-duration: 0.1s !important;
			transition-timing-function: linear !important;
			transition-delay: 0.1s !important;
		}
		.aside-logo:hover .text-logo:not( :hover ) {
			webkit-filter: blur(3px); /* Chrome, Safari, Opera */
			filter: blur(3px);
		}
		.text-logo:hover {
			webkit-filter: blur(3px); /* Chrome, Safari, Opera */
			filter: blur(3px);
		}
		.aside-logo:hover .text-date:not( :hover ) {
			webkit-filter: blur(3px); /* Chrome, Safari, Opera */
			filter: blur(3px);
		}
		.text-date:hover {
			webkit-filter: blur(3px); /* Chrome, Safari, Opera */
			filter: blur(3px);
		}
		.img-logo {
			transition: transform .2s; /* Animation */
		}
		.aside-logo:hover .img-logo:not( :hover ) {
			transition: transform .2s; /* Animation */
			transform: scale(1.5);
		}
		.img-logo:hover {
			transition: transform .2s; /* Animation */
			transform: scale(1.5);
		}
	</style>
@endpush
