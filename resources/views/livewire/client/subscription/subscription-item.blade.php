<div class="col-12 col-sm-6 col-md-6 col-xl-4 mb-3 ">
    <!--begin::Card-->
    <div class="card bg-hover-secondary">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-9 d-flex justify-content-center">
            <!--begin::Card Title-->
            <div class="card-title m-0">
                <!--begin::Avatar-->
                <h1 class="fw-bolder">{{convertNumbers($planUser->plan_title)}}</h1>
                <!--end::Avatar-->
            </div>
            <!--end::Car Title-->
        </div>
        <!--end:: Card header-->
        <!--begin:: Card body-->
        <div class="card-body p-9">

            <!--begin::،Title-->
            <div class="fs-3 fw-bold text-dark text-center">
                {{convertNumbers($planUser->plan_duration)}} روز
            </div>

            <div class="separator border-4 my-3 w-50 mx-auto"></div>

            <!--begin::،Title-->
            <div class="fs-3 fw-bold text-dark text-center">
                @if(is_null($planUser->plan_traffic))
                    ترافیک نامحدود
                @else
                    {{convertNumbers(formatBytes($planUser->plan_traffic))}}
                @endif
            </div>

            <div class="separator border-4 my-3 w-50 mx-auto"></div>

            <!--begin::،Title-->
            <div class="fs-3 fw-bold text-dark text-center">
                {{convertNumbers(number_format($planUser->remaining_user_count))}} عدد باقی مانده
            </div>

            <div class="separator border-4 my-3 w-50 mx-auto"></div>
            <!--end::Title-->

            <div class="text-center">
                <span
                    class="fs-3x fw-bold text-primary">{{convertNumbers(number_format($subscriptionPrice))}}</span>
                {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-2x text-primary ms-1') !!}
                <span class="fs-7 fw-semibold opacity-50"></span>
            </div>


            <!--begin::Info-->
            <div class="d-flex flex-wrap mb-0 mt-2 justify-content-center align-items-baseline" wire:target="buy"
                 wire:loading.class="d-none">
                <!--begin::Budget-->
                <button class="btn btn-primary" onclick="buySubscription({{$planUser->id}})">خرید</button>
                <!--end::Budget-->
            </div>
            <!--end::Info-->

            <div class="text-center mt-3">
                <a class="text-gray-600 text-hover-primary border-bottom-1 border-bottom-dashed" href="#">مشاهده امکانات</a>
            </div>

            <!--begin::Spinner-->
            <div class="d-flex flex-wrap mb-0 mt-2 justify-content-center align-items-baseline d-none" wire:target="buy"
                 wire:loading.class.remove="d-none">
                <span class="spinner-border spinner-border-lg align-middle fw-bolder"></span>
            </div>
            <!--end::Spinner-->

        </div>
        <!--end:: Card body-->
    </div>
    <!--end::Card-->
</div>
