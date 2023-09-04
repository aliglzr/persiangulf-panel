<!--begin::Menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px"
     data-kt-menu="true">
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <div class="menu-content d-flex align-items-center px-3">
            <!--begin::Avatar-->
            <div class="symbol symbol-50px me-5">
                <img alt="Logo" src="{{ auth()->user()->getAvatarUrl() }}"/>
            </div>
            <!--end::Avatar-->

            <!--begin::Username-->
            <div class="d-flex flex-column">
                <div class="fw-bolder d-flex align-items-center fs-5">
                    @if(!auth()->user()->isClient())
                        {{ auth()->user()->fullname }}
                    @else
                        {{ strtoupper(auth()->user()->username) }}
                    @endif
                    <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2 user-select-none">{{ auth()->user()->getRole('slug') }}</span>
                </div>
                @if(!auth()->user()->isClient())
                    <a href="{{auth()->user()->getProfileLink()}}"
                       class="fw-bold text-muted text-hover-primary fs-7">{{ strtoupper(auth()->user()->username) }}</a>
                @endif
                @if(auth()->user()?->introducer?->username != 'solidvpn_sales')
                    @role('client')
                    <span data-bs-toggle="tooltip" title="معرف شما"
                          class="fw-bold text-muted text-hover-primary fs-7 user-select-none"><i
                                class="fa fa-user-tie me-2"></i>{{ convertNumbers(auth()->user()?->introducer?->username) }}</span>
                    @endrole
                @endif
            </div>
            <!--end::Username-->
        </div>
    </div>
    <!--end::Menu item-->

    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->

    <!--begin::Menu item-->
    <div class="menu-item px-5">
        <a href="{{ auth()->user()->getProfileLink() }}" class="menu-link px-5">
            پروفایل
        </a>
    </div>
    <!--end::Menu item-->

    @role('client')
    <!--begin::Menu item-->
    <div class="menu-item px-5">
        <a href="{{auth()->user()->getProfileLink('subscriptions')}}" class="menu-link px-5">
            <span class="menu-text">اشتراک های من</span>
        </a>
    </div>
    <!--end::Menu item-->
    @endrole

    @role('agent')
    <!--begin::Menu item-->
    <div class="menu-item px-5">
        <a href="{{auth()->user()->getProfileLink('plans')}}" class="menu-link px-5">
            <span class="menu-text">طرح های من</span>
            <span class="menu-badge">
                <span class="badge badge-light-danger badge-circle fw-bolder fs-7">{{convertNumbers(auth()->user()->plans()->wherePivot('remaining_user_count','>',0)->wherePivot('active',1)->count())}}</span>
            </span>
        </a>
    </div>
    <div class="menu-item px-5">
        <a href="{{auth()->user()->getProfileLink('clients')}}" class="menu-link px-5">
            <span class="menu-text">مشتریان من</span>
            <span class="menu-badge">
                <span class="badge badge-light-danger badge-circle fw-bolder fs-7">{{convertNumbers(auth()->user()->clients()->count())}}</span>
            </span>
        </a>
    </div>
    <!--end::Menu item-->
    @endrole


    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->


    <!--begin::Menu item-->
    <div class="menu-item px-5">
        <a href="#" data-action="{{ route('logout') }}" data-method="post" data-csrf="{{ csrf_token() }}"
           data-reload="true" class="button-ajax menu-link px-5 text-danger">
            خروج از حساب
        </a>
    </div>
    <!--end::Menu item-->

    @if (theme()->isDarkModeEnabled())
        <!--begin::Menu separator-->
        <div class="separator my-2"></div>
        <!--end::Menu separator-->

        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <div class="menu-content px-5">
                <label class="form-check form-switch form-check-custom form-check-solid pulse pulse-success"
                       for="kt_user_menu_dark_mode_toggle">
                    <input class="form-check-input w-30px h-20px" type="checkbox" value="1" name="skin"
                           id="kt_user_menu_dark_mode_toggle"
                           {{ theme()->isDarkMode() ? 'checked' : '' }} data-kt-url="{{ theme()->getPageUrl('', '', theme()->isDarkMode() ? '' : 'dark') }}"/>
                    <span class="pulse-ring ms-n1"></span>

                    <span class="form-check-label text-gray-600 fs-7">
                        {{ __('Dark Mode') }}
                    </span>
                </label>
            </div>
        </div>
        <!--end::Menu item-->
    @endif
</div>
<!--end::Menu-->
