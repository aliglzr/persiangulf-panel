<div>
    <div class="card mb-5 mb-xl-10">
        @php
            /* @var \App\Models\User $user */
        @endphp
        <div class="card-body pt-9 pb-0 ">
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
                                <a href="{{route('dashboard')}}" onclick="event.preventDefault();copyToClipboard('agent_username')" id="agent_username" class="text-gray-800 text-hover-primary fs-2 fw-bolder me-1">{{ $user->username }}</a>
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
                                    <i class="fa fa-user fs-4 me-1"></i>
                                    {{$user->roles()->first()?->slug}}
                                </a>

                                @if($user->email)
                                    <a href="#" onclick="event.preventDefault();copyToClipboard('agent_email')" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                        <i class="fa fa-at fs-4 me-1"></i>
                                        <span id="agent_email">{{ $user->email }}</span>
                                    </a>
                                @endif
                                @if( auth()->user()->isManager() || auth()->user()->hasRole('support') )
                                <span onclick="event.preventDefault();copyToClipboard('agent_balance')" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2" data-bs-toggle="tooltip" title="اعتبار">
                                    <i class="fa fa-wallet fs-4 me-1"></i>
                                    {{convertNumbers(number_format($user->balance))}}
                                    {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3') !!}
                                    <span class="d-none" id="agent_balance">{{$user->balance}}</span>
                                </span>
                                @endif

                                @if( (auth()->user()->isManager() || auth()->user()->hasRole('support')) && !is_null($user->introducer) )
                                    <a href="{{route('agents.overview',$user->introducer)}}" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2" data-bs-toggle="tooltip" title="معرف">
                                    <i class="fa fa-user-group fs-4 me-1"></i>
                                    {{$user->introducer?->full_name}}
                                </a>
                                @endif

                                <span onclick="copyToClipboard('invite_code')" class="d-flex align-items-center text-gray-400 text-hover-primary ms-5 mb-2 cursor-pointer" data-bs-toggle="tooltip" title="کد دعوت">
                                    <i class="fa fa-gift fs-4 me-1"></i>
                                    <span id="invite_code">{{$user?->invite_code}}</span>
                                </span>

                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                    @if(auth()->user()->isManager() || auth()->user()->hasRole('support')  )
                        <!--begin::Actions-->
                            <div class="d-flex my-4">
                                <button  class="btn btn-sm btn-primary me-3" data-bs-toggle="modal" data-bs-target="#submit_ticket_for_user_modal">ثبت تیکت</button>
                                <button class="btn btn-sm btn-primary me-3" wire:click.prevent="login()">ورود به حساب این کاربر</button>
                                @if(auth()->user()->isManager())
                                <button class="btn btn-sm btn-primary me-3" data-bs-toggle="modal" data-bs-target="#change_user_balance">تغییر اعتبار</button>
                                    @endif
                            </div>
                            <!--end::Actions-->

                        @endif
                    </div>
                    <!--end::Title-->

                    <!--begin::Stats-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->

            <!--begin::Navs-->
            <div class="d-flex overflow-auto h-55px">
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder flex-nowrap">
                @if(auth()->user()->id == $user->id || auth()->user()->can('view-agent-overview'))
                    <!--begin::Nav item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary me-6 {{ request()->segment('3') == '' ? 'active' : ''  }}" href="{{route('agents.overview',['user' => $user])}}">
                                جزییات
                            </a>
                        </li>
                        <!--end::Nav item-->
                @endif
                @if(auth()->user()->id == $user->id || auth()->user()->can('view-agent-security'))
                    <!--begin::Nav item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary me-6 {{ request()->segment('3') == 'security' ? 'active' : ''  }}" href="{{route('agents.security',['user' => $user])}}">
                                امنیت
                            </a>
                        </li>
                        <!--end::Nav item-->
                @endif
                @if(config('app.env') == 'local')
                @if(auth()->user()->id == $user->id || auth()->user()->can('view-agent-references'))
                    <!--begin::Nav item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary me-6 {{ request()->segment('3') == 'references' ? 'active' : ''  }}" href="{{route('agents.references',['user' => $user])}}">
                                معرفی شدگان
                            </a>
                        </li>
                        <!--end::Nav item-->
                @endif
                @endif
                @if(auth()->user()->id == $user->id || auth()->user()->can('view-agent-clients'))
                    <!--begin::Nav item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary me-6 {{ request()->segment('3') == 'clients' ? 'active' : ''  }}" href="{{route('agents.clients',['user' => $user])}}">
                                مشتریان
                            </a>
                        </li>
                        <!--end::Nav item-->
                @endif
                @if(auth()->user()->id == $user->id || auth()->user()->can('view-agent-plans'))
                    <!--begin::Nav item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary me-6 {{ request()->segment('3') == 'plans' ? 'active' : ''  }}" href="{{route('agents.plans',['user' => $user])}}">
                                طرح ها
                            </a>
                        </li>
                        <!--end::Nav item-->
                @endif
                @if(auth()->user()->id == $user->id || auth()->user()->can('view-agent-financial'))
                    <!--begin::Nav item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary me-6 {{ request()->segment('3') == 'financial' ? 'active' : ''  }}" href="{{route('agents.financial',['user' => $user])}}">
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
            <livewire:profile.submit-ticket-modal :user="$user" />
        @endif
        @if(auth()->user()->isManager())
            <livewire:profile.change-balance :user="$user"/>
            @endif
    </div>
</div>
@push('scripts')
    @endpush
