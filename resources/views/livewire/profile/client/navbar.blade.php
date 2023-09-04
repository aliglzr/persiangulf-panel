<div class="card mb-5 mb-xl-10" xmlns:wire="http://www.w3.org/1999/xhtml">
    @php
    /* @var \App\Models\User $user */
    @endphp
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
            <!--begin::Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <!--begin::User-->
                    <div class="d-flex flex-column">
                        <!--begin::Name-->
                        <div class="d-flex align-items-center mb-2">
                            <a href="{{auth()->user()->isManager() || auth()->user()->isSupport() || auth()->user()->id == $user->id ? "/$user->username/home" : '' }}" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">{{ $user->username }}</a>
                            @if($user->roles()->first()?->name == 'agent')
                                <a href="#">
                                    {!! theme()->getSvgIcon("icons/duotune/general/gen026.svg", "svg-icon-1 svg-icon-primary") !!}
                                </a>
                            @endif
                        </div>
                        <!--end::Name-->

                        <!--begin::Info-->
                        <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                <i class="fa fa-id-card fs-4 me-1"></i>
                                {{$user->id}}
                            </a>
                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                <i class="fa fa-user fs-4 me-1"></i>
                                {{$user->roles()->first()?->slug}}
                            </a>
                            @if($user->email)
                                <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <i class="fa fa-at fs-4 me-1"></i>
                                    {{ $user->email }}
                                </a>
                            @endif

                            @if( auth()->user()->isManager() || auth()->user()->hasRole('support') )
                            <span class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2" data-bs-toggle="tooltip" title="اعتبار">
                                    <i class="fa fa-wallet fs-4 me-1"></i>
                                    {{convertNumbers(number_format($user->balance))}}
                                    {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3') !!}
                                </span>
                            @endif

                            @if( (auth()->user()->isManager() || auth()->user()->hasRole('support')) && !is_null($user->introducer) )
                                <span class="d-flex align-items-center text-gray-400 text-hover-primary mb-2" data-bs-toggle="tooltip" title="معرف">
                                    <i class="fa fa-user-group fs-4 me-1"></i>
                                    {{$user->introducer?->full_name}}
                                </span>
                            @endif

                            @if( auth()->user()->isManager() || auth()->user()->hasRole('support') )
                                <a href="{{route('layers.show',$user->layer)}}" class="d-flex align-items-center text-gray-400 text-hover-primary ms-5 mb-2" data-bs-toggle="tooltip" title="لایه">
                                    <i class="bi bi-layers-half fs-4 me-1"></i>
                                    {{$user->layer->name}}
                                </a>
                            @endif

                            @if( auth()->user()->isManager() || auth()->user()->hasRole('support') )
                                <span onclick="copyToClipboard('user_uuid')" class="cursor-pointer d-flex align-items-center text-gray-400 text-hover-primary ms-5 mb-2" data-bs-toggle="tooltip" title="UUID">
                                    <i class="bi bi-layers-half fs-4 me-1"></i>
                                    <span id="user_uuid">{{$user->uuid}}</span>
                                </span>
                            @endif

                            <span onclick="copyToClipboard('invite_code')" class="cursor-pointer d-flex align-items-center text-gray-400 text-hover-primary ms-5 mb-2" data-bs-toggle="tooltip" title="کد دعوت">
                                    <i class="fa fa-gift fs-4 me-1"></i>
                                     <span id="invite_code">{{$user?->invite_code}}</span>
                                </span>

                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::User-->
                @if(auth()->user()->isManager() || auth()->user()->hasRole('support') )
                    <!--begin::Actions-->
                                    <div class="d-flex my-4">
                                        <button  class="btn btn-sm btn-primary me-3" data-bs-toggle="modal" data-bs-target="#submit_ticket_for_user_modal">ثبت تیکت</button>
                                        @if(auth()->user()->isManager())
                                            <div class="me-0">
                                                <button data-bs-toggle="tooltip" aria-label="عملیات" data-bs-original-title="عملیات" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="hover" data-kt-menu-placement="bottom-end">
                                                    <i class="bi bi-three-dots fs-3"></i>
                                                </button>

                                                <!--begin::Menu 3-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true" style="">
                                                    <!--begin::Heading-->
                                                    <div class="menu-item px-3">
                                                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                                            عملیات
                                                        </div>
                                                    </div>
                                                    <!--end::Heading-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a  data-bs-toggle="modal" data-bs-target="#reset_traffic_and_active_client_connections_modal" class="menu-link px-3">
                                                            ریست کردن ترافیک مصرفی کاربر
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a  data-bs-toggle="modal" wire:click.prevent="activeConnection()" class="menu-link px-3">
                                                            فعال سازی مجدد اشتراک
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a wire:click.prevent="login()" class="menu-link flex-stack px-3">
                                                            ورود به حساب این کاربر
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3 my-1">
                                                        <a data-bs-toggle="modal" data-bs-target="#change_user_balance" class="menu-link px-3">
                                                            تغییر اعتبار
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                </div>
                                                <!--end::Menu 3-->
                                            </div>
                                        @endif
                                    </div>
                <!--end::Actions-->
                    @elseif(auth()->user()->isAgent() && $user->reference_id == auth()->id())

                        <!--begin::Actions-->
                        <div class="d-flex my-4">
                                <div class="me-0">
                                    <button data-bs-toggle="tooltip" aria-label="عملیات" data-bs-original-title="عملیات" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="hover" data-kt-menu-placement="bottom-end">
                                        <i class="bi bi-three-dots fs-3"></i>
                                    </button>

                                    <!--begin::Menu 3-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true" style="">
                                        <!--begin::Heading-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                                عملیات
                                            </div>
                                        </div>
                                        <!--end::Heading-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a wire:click.prevent="login()" class="menu-link flex-stack px-3">
                                                ورود به حساب این کاربر
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 3-->
                                </div>
                        </div>
                        <!--end::Actions-->
                    @endif
                </div>
                <!--end::Title-->
            </div>
            <!--end::Info-->
        </div>
        <!--end::Details-->

        <!--begin::Navs-->
        <div class="d-flex overflow-auto h-55px">
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
            @if(auth()->user()->id == $user->id || (auth()->user()->isAgent() && auth()->user()->id == $user->introducer?->id) || auth()->user()->can('view-client-overview'))
                <!--begin::Nav item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary me-6 {{ request()->segment('3') == '' ? 'active' : ''  }}" href="{{route('clients.overview',['user' => $user])}}">
                        جزییات
                    </a>
                </li>
                <!--end::Nav item-->
            @endif
            @if(auth()->user()->id == $user->id || (auth()->user()->isAgent() && auth()->user()->id == $user->introducer?->id) || auth()->user()->can('view-client-subscriptions'))
                <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6 {{ request()->segment('3') == 'subscriptions' ? 'active' : ''  }}" href="{{route('clients.subscriptions',['user' => $user])}}">
                            اشتراک ها
                        </a>
                    </li>
                    <!--end::Nav item-->
                @endif
            @if(auth()->user()->id == $user->id || (auth()->user()->isAgent() && auth()->user()->id == $user->introducer?->id) || auth()->user()->can('view-client-financial'))
                <!--begin::Nav item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary me-6 {{ request()->segment('3') == 'financial' ? 'active' : ''  }}" href="{{route('clients.financial',['user' => $user])}}">
                            مالی
                        </a>
                    </li>
                    <!--end::Nav item-->
                @endif
            </ul>
        </div>
        <!--begin::Navs-->
    </div>
    @if(auth()->user()->isManager() || auth()->user()->hasRole('support') || auth()->user()->can('submit-ticket-for-users'))
    <livewire:profile.submit-ticket-modal :user="$user"/>
        @endif
    @if(auth()->user()->isManager())
        <livewire:profile.client.reset-traffic-and-active-client-connections :user="$user" />
        <livewire:profile.change-balance :user="$user"/>
    @endif
</div>
