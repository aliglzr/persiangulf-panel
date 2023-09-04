<!--begin::Menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-bg-light-primary fw-semibold py-4 fs-base w-200px" data-kt-menu="true">
	<!--begin::Menu item-->
	<div class="menu-item px-3 mt-0 mb-1">
		<a href="#" class="menu-link px-3 py-2" data-bs-toggle="modal" data-bs-target="#increaseCredit">
			<span class="menu-icon" data-kt-element="icon">
				<!--begin::Svg Icon | path: icons/duotune/general/gen061.svg-->
				<i class="fa fa-hand-holding-dollar fs-4"></i>
            <!--end::Svg Icon-->
			</span>
			<span class="menu-title">افزایش اعتبار</span>
		</a>
	</div>

    <div class="separator separator-dashed mb-1 mt-1"></div>
	<!--end::Menu item-->
    <div class="menu-item px-3 mt-1">
        <a href="{{auth()->user()->getProfileLink('financial').'#invoices-table'}}" class="menu-link px-3 py-2">
			<span class="menu-icon" data-kt-element="icon">
				<!--begin::Svg Icon | path: icons/duotune/general/gen061.svg-->
           <i class="fa fa-money-check-dollar fs-4"></i>
            <!--end::Svg Icon-->
			</span>
            <span class="menu-title">صورت‌حساب های من</span>
        </a>
    </div>
    <div class="menu-item px-3 mt-1">
        <a href="{{auth()->user()->getProfileLink('financial').'#payments-table'}}" class="menu-link px-3 py-2">
			<span class="menu-icon" data-kt-element="icon">
				<!--begin::Svg Icon | path: icons/duotune/general/gen061.svg-->
           <i class="fa fa-file-invoice fs-4"></i>
                <!--end::Svg Icon-->
			</span>
            <span class="menu-title">پرداخت های من</span>
        </a>
    </div>

    <div class="menu-item px-3 mt-1">
        <a href="{{auth()->user()->getProfileLink('financial').'#transactions-table'}}" class="menu-link px-3 py-2">
			<span class="menu-icon" data-kt-element="icon">
				<!--begin::Svg Icon | path: icons/duotune/general/gen061.svg-->
           <i class="fa fa-file-invoice-dollar fs-4"></i>
                <!--end::Svg Icon-->
			</span>
            <span class="menu-title">تراکنش های من</span>
        </a>
    </div>


</div>
<!--end::Menu-->

