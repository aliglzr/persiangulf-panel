<div class="col-lg-6 mb-3">
    <div class="p-5 border-dashed border-gray-200 ribbon ribbon-top">
        <div class="ribbon-label bg-primary">قیمت منصفانه فروش: {{convertNumbers(number_format($planUser->plan_sell_price))}} {!! get_svg_icon('svg/coins/toman.svg','svg-icon text-dark svg-icon-3') !!} </div>

        <!--begin::Heading-->
        <div class="d-flex justify-content-between align-items-baseline">
            <h3 class="mb-2 h2">{{$planUser->plan_title}}</h3>
        </div>
        <!--end::Heading-->

        <!--begin::Heading-->
        <div class="d-flex text-muted fw-bold fs-5 mb-3 mt-3">
            <span class="flex-grow-1 text-gray-800">باقیمانده اشتراک</span>
            <span class="text-gray-800">{{convertNumbers($this->remaining_users_count)}} اشتراک از {{convertNumbers($planUser->plan_users_count)}} اشتراک باقی مانده</span>
        </div>
        <!--end::Heading-->
        <!--begin::Progress-->
        <div class="progress h-8px bg-light-primary mb-2">
            <div class="progress-bar bg-primary" role="progressbar" style="width: {{$this->remainingPercent}}%" aria-valuenow="{{$this->remainingPercent}}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <!--end::Progress-->

        <!--begin::Info-->
        <div class="fs-5 mb-2">
            <span class="text-gray-800 fw-bold me-1"><i class="fa fa-clock"></i></span>
            <span class="text-gray-600 fw-semibold">{{convertNumbers($planUser->plan_duration)}} روزه</span>
            <span class="text-gray-800 fw-bold ms-2"><i class="fa fa-user"></i></span>
            <span class="text-gray-600 fw-semibold">{{convertNumbers($planUser->plan_users_count)}} اشتراک</span>
            <span class="text-gray-800 fw-bold ms-2"><i class="fa fa-cloud-arrow-down"></i></span>
            <span class="text-gray-600 fw-semibold">
                      @if(is_null($planUser->plan_traffic))
                    نامحدود
                @else
                    {{convertNumbers(formatBytes($planUser->plan_traffic))}}
                @endif
            </span>
            <span class="text-gray-800 fw-bold ms-2"><i class="fa fa-dollar-sign"></i></span>
            <span class="text-gray-600 fw-semibold">{{convertNumbers(number_format($planUser->plan_price))}} {!! get_svg_icon('svg/coins/toman.svg','svg-icon text-gray-600 svg-icon-3') !!}</span>
        </div>
        <!--end::Info-->
        <!--begin::Notice-->
        <div class="d-flex justify-content-start pb-0 px-0">
            {{--                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary me-2">Cancel PlanUser</a>--}}
            <button class="btn btn-sm btn-primary" wire:click="$emit('setPlanUser',{{$planUser->id}})"> ثبت مشتری <i class="fas fa-user-plus ms-2"></i></button>
            <a href="{{route('invoices.show',$planUser->invoice_id)}}" class="btn btn-sm btn-outline btn-outline-dashed btn-outline-primary ms-3 btn-active-light-primary">مشاهده صورتحساب</a>
            @if(auth()->user()->isManager())
            <button wire:click="$emit('editPlanUser',{{$planUser->id}})" class="btn btn-sm btn-outline btn-outline-dashed btn-outline-primary ms-3 btn-active-light-primary">ویرایش طرح</button>
                @endif
        </div>
        <!--end::Notice-->
    </div>
</div>
