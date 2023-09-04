<div class="card mb-5 mb-xl-10">

    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title ">
            <h2>طرح های فعال</h2>
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Filter-->
                     @role('agent')
            <a href="{{route('plans.buy')}}" type="button" class="btn btn-flex btn-light-primary">
                <?= get_svg_icon('icons/duotone/Interface/Sign-Out.svg') ?>
                خرید طرح
            </a>
                      @endrole
        <!--end::Filter-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body">
        <!--begin::Notice-->
    {{--        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-12 p-6">--}}
    {{--            <!--begin::Icon-->--}}
    {{--            <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->--}}
    {{--            <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">--}}
    {{--											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
    {{--												<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>--}}
    {{--												<rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"></rect>--}}
    {{--												<rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"></rect>--}}
    {{--											</svg>--}}
    {{--										</span>--}}
    {{--            <!--end::Svg Icon-->--}}
    {{--            <!--end::Icon-->--}}
    {{--            <!--begin::Wrapper-->--}}
    {{--            <div class="d-flex flex-stack flex-grow-1">--}}
    {{--                <!--begin::Content-->--}}
    {{--                <div class="fw-semibold">--}}
    {{--                    <h4 class="text-gray-900 fw-bold">We need your attention!</h4>--}}
    {{--                    <div class="fs-6 text-gray-700">Your payment was declined. To start using tools, please--}}
    {{--                        <a href="#" class="fw-bold" data-bs-toggle="modal" data-bs-target="#kt_modal_new_card">Add Payment Method</a>.</div>--}}
    {{--                </div>--}}
    {{--                <!--end::Content-->--}}
    {{--            </div>--}}
    {{--            <!--end::Wrapper-->--}}
    {{--        </div>--}}
    <!--end::Notice-->
        <!--begin::Row-->
        @if($planUsers->count())
        <div class="row">
            @foreach($planUsers as $planUser)
                <livewire:profile.agent.plans.plan-user-item :planUser="$planUser" :user="$user" :wire:key="$planUser->id"/>
            @endforeach
        </div>
        @else
        <div class="d-flex flex-column align-items-center">
            <div>
                <img class="h-200px" src="{{asset(theme()->isDarkMode() ? 'media/illustrations/sigma-1/17.png' : 'media/illustrations/sigma-1/17-dark.png') }}" alt="">
            </div>
            <div class="d-flex flex-column justify-content-center align-content-center">
                <div class="fs-1 fw-bold mt-8">طرح فعالی یافت نشد</div>
{{--                <a href="#" class="btn btn-secondary m-10 mt-5">خرید طرح</a>--}}
            </div>

        </div>
        @endif
        <!--end::Row-->
    </div>
    <!--end::Card body-->
    <livewire:profile.agent.plans.edit-plan-user />

</div>
