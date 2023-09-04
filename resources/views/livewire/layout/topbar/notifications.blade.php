<div wire:ignore.self class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">
    <button id="test" class="d-none"></button>
    @php
    $svgs = [ 'success' => 'fa-check', 'danger' => 'fa-xmark', 'warning' => 'fa-exclamation', 'info' => 'fa-info' ];
    @endphp
    <!--begin::Heading-->
    <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('{{ asset(theme()->getMediaUrlPath() . 'misc/pattern-1.jpg') }}')">
        <!--begin::Title-->
        <h3 class="text-white fw-semibold px-9 mt-10 mb-6">اطلاعیه ها
        </h3>
        <!--end::Title-->
    </div>
    <!--end::Heading-->
    <!--begin::Tab content-->
    <div class="tab-content">
        <!--begin::Tab panel-->
        <div wire:ignore.self>
            <!--begin::Items-->
            <div class="my-5 px-8 {{$unreadNotifications?->count() == 0 ? '' : 'scroll-y mh-325px'}}">
            @if($unreadNotifications?->count())
                @foreach($unreadNotifications as $unreadNotification)
                    <!--begin::Item-->
                        <div :wire:key="$unreadNotification->id" class="d-flex flex-stack py-4">
                            <!--begin::Section-->
                            <div class="d-flex align-items-center">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-35px me-4">
							<span class="symbol-label bg-light-{{$unreadNotification->data['toast_type'] ?? ''}}">
								<!--begin::Svg Icon | path: icons/duotune/technology/teh008.svg-->
                                <i class="svg-icon svg-icon-2 svg-icon-{{$unreadNotification->data['toast_type'] ?? ''}} fa-solid  {{$svgs[$unreadNotification->data['toast_type']]}}"></i>
{{--							    {!! get_svg_icon('icons/duotune/technology/teh008.svg','svg-icon svg-icon-2 svg-icon-primary') !!}--}}
                            <!--end::Svg Icon-->
							</span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Title-->
                                <div class="mb-0 me-2">
                                    <a href="{{route('open.notification',$unreadNotification)}}" class="fs-6 text-gray-800 text-hover-primary fw-bold">{{$unreadNotification->data['title'] ?? ''}}</a>
                                    <div class="text-gray-400 fs-7">{{$unreadNotification->data['body'] ?? ''}}</div>
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Label-->
                            <span class="badge badge-light fs-8">{{convertNumbers(\Illuminate\Support\Carbon::instance($unreadNotification->created_at)->diffForHumans())}}</span>
                            <!--end::Label-->
                        </div>
                        <!--end::Item-->
                @endforeach
            @else
                <!--begin::Wrapper-->
                    <div class="d-flex flex-column px-9">
                        <!--begin::Section-->
                        <div class="pt-10 pb-0">
                            <!--begin::Title-->
                            <h3 class="text-dark text-center fw-bold">اطلاعیه ای جهت نمایش وجود ندارد</h3>
                            <!--end::Title-->
                        </div>
                        <!--end::Section-->
                        <!--begin::Illustration-->
                        <div class="text-center px-4">
                            <img class="mw-100 mh-200px" alt="image" src="{{ asset('media/illustrations/sigma-1/13-dark.png') }}" />
                        </div>
                        <!--end::Illustration-->
                    </div>
                    <!--end::Wrapper-->
                @endif
            </div>
            <!--end::Items-->

            <!--begin::View more-->
            <div class="py-3 text-center border-top {{$unreadNotifications?->count() == 0 ? 'd-none' : ''}}">
                <button href="#" wire:click.prevent="markAsRead()" class="btn btn-color-gray-600 btn-active-color-primary">خواندن همه
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                {!! get_svg_icon('icons/duotune/arrows/arr064.svg','svg-icon svg-icon-5') !!}
                    <!--end::Svg Icon--></button>
            </div>
            <!--end::View more-->
        </div>
        <!--end::Tab panel-->
    </div>
    <!--end::Tab content-->
</div>

@push('scripts')
    <script>
        Echo.private('App.Models.User.{{$user->id}}')
            .notification((notification) => {
                if(notification['type'] === 'App\\Notifications\\TicketsNotifications\\NewTicketMessageNotification') {
                    if('{{request()->getRequestUri()}}' !== notification['link']) {
                        @this.notifyNewNotification(notification);
                        (new Audio('{{asset('media/sounds/notification.wav')}}')).play()
                    }
                } else {
                    @this.notifyNewNotification(notification);
                    (new Audio('{{asset('media/sounds/notification.wav')}}')).play()
                }
            });
    </script>
    @endpush

