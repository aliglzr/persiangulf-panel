<!--begin::Demos drawer-->
<div
	id="kt_engage_demos"
	class="bg-body"
	data-kt-drawer="true"
	data-kt-drawer-name="explore"
	data-kt-drawer-activate="true"
	data-kt-drawer-overlay="true"
	data-kt-drawer-width="{default:'350px', 'lg': '475px'}"
	data-kt-drawer-direction="{{ theme()->getOption('layout', 'engage/demos/direction') }}"
	data-kt-drawer-toggle="#kt_engage_demos_toggle"
	data-kt-drawer-close="#kt_engage_demos_close">

    <!--begin::Card-->
	<div class="card shadow-none rounded-0 w-100">
		<!--begin::Header-->
		<div class="card-header" id="kt_engage_demos_header">
			<h3 class="card-title fw-bolder text-gray-700">Explore <?php //echo theme()->getProductName()?></h3>

			<div class="card-toolbar">
				<button type="button" class="btn btn-sm btn-icon btn-active-color-primary h-40px w-40px me-n6" id="kt_engage_demos_close">
					{!! theme()->getSvgIcon("icons/duotune/arrows/arr061.svg", "svg-icon-2") !!}
				</button>
			</div>
		</div>
		<!--end::Header-->

		<!--begin::Body-->
		<div class="card-body" id="kt_engage_demos_body">
			<!--begin::Content-->
			<div
                id="kt_explore_scroll"
				class="scroll-y me-n5 pe-5"
				data-kt-scroll="true"
				data-kt-scroll-height="auto"
				data-kt-scroll-wrappers="#kt_engage_demos_body"
				data-kt-scroll-dependencies="#kt_engage_demos_header"
				data-kt-scroll-offset="5px">

                <!--begin::Wrapper-->
                <div class="mb-0">
					<!--begin::Heading-->
					<div class="mb-7">
						<div class="d-flex flex-stack">
							<h3 class="mb-0">{{ theme()->getProductName() }} Licenses</h3>

							<a href="{{ theme()->getOption('product', 'licenses/terms') }}" class="fw-bold" target="_blank">
								License FAQs
							</a>
						</div>
					</div>
					<!--end::Heading-->

					@foreach(theme()->getOption('product', 'licenses/types') as $license)
						<!--begin::License-->
						<div class="rounded border border-dashed border-gray-300 py-4 px-6 mb-5">
							<div class="d-flex flex-stack">
								<div class="d-flex flex-column">
									<div class="d-flex align-items-center mb-1">
										<div class="fs-6 fw-bold text-gray-800 fw-bold mb-0 me-1">{{ $license['title'] }}</div>

										<i class="text-gray-400 fas fa-exclamation-circle ms-1 fs-7"
											data-bs-toggle="popover"
											data-bs-trigger="hover"
											data-bs-placement="top"
											data-bs-content="{{ $license['tooltip'] }}">
										</i>
									</div>
									<div class="fs-7 text-muted">{{ $license['description'] }}</div>
								</div>

								<div class="text-nowrap">
									<span class="text-muted fs-7 fw-bold me-n1">$</span>
									<span class="text-dark fs-1 fw-bolder">{{ $license['price'] }}</span>
								</div>
							</div>
						</div>
						<!--end::License-->
					@endforeach

					<!--begin::License-->
					<div class="rounded border border-dashed border-gray-300 py-4 px-6 mb-5">
						<div class="d-flex flex-stack">
							<div class="d-flex flex-column">
								<div class="d-flex align-items-center mb-1">
									<div class="fs-6 fw-bold text-gray-800 fw-bold mb-0 me-1">Custom License</div>
								</div>
								<div class="fs-7 text-muted">Reach us for custom license offers.</div>
							</div>

							<div class="text-nowrap">
								<a href="https://keenthemes.com/contact/" class="btn btn-sm btn-success" target="_blank">Contact Us</a>
							</div>
						</div>
					</div>
					<!--end::License-->

					<!--begin::Purchase-->
					<a href="{{ theme()->getOption('product', 'purchase') }}" class="btn btn-primary mb-15 w-100">
						Buy Now
					</a>
					<!--end::Purchase-->
                </div>
                <!--end::Wrapper-->
			</div>
			<!--end::Content-->
		</div>
		<!--end::Body-->
	</div>
    <!--end::Card-->
</div>
<!--end::Demos drawer-->

