<div class="col-12 col-sm-6 col-md-6 col-xl-4 mb-3 ">
    <!--begin::Card-->
    <div class="card bg-hover-secondary ribbon ribbon-top">
        <div class="ribbon-label bg-primary">قیمت منصفانه فروش: {{convertNumbers(number_format($plan->sell_price))}} {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3 text-dark ms-1') !!}  </div>
        <!--begin::Card header-->
        <div class="card-header border-0 pt-9 d-flex justify-content-center">
            <!--begin::Card Title-->
            <div class="card-title m-0">
                <!--begin::Avatar-->
                <h1 class="fw-bolder">{{convertNumbers($plan->title)}}</h1>
                <!--end::Avatar-->
            </div>
            <!--end::Car Title-->
        </div>
        <!--end:: Card header-->
        <!--begin:: Card body-->
        <div class="card-body p-9">

            <!--begin::Users Count-->
            <div class="fs-3 fw-bold text-dark text-center">
                تعداد: {{convertNumbers($plan->users_count)}} اشتراک
            </div>
            <!--end::Users Count-->

            <div class="separator border-4 my-3 w-50 mx-auto"></div>

            <!--begin::،Title-->
            <div class="fs-3 fw-bold text-dark text-center">
                اشتراک {{convertNumbers($plan->duration)}}روزه
            </div>

            <div class="separator border-4 my-3 w-50 mx-auto"></div>

            <!--begin::،Title-->
            <div class="fs-3 fw-bold text-dark text-center">
                @if(is_null($plan->traffic))
                    ترافیک نامحدود
                @else
                    {{convertNumbers(formatBytes($plan->traffic))}}
                    @endif
            </div>

            <div class="separator border-4 my-3 w-50 mx-auto"></div>
            <!--end::Title-->

            <div class="text-center">
                <span
                    class="fs-3x fw-bold text-primary">{{convertNumbers(number_format($plan->price))}}</span>
                {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-2x text-primary ms-1') !!}
                <span class="fs-7 fw-semibold opacity-50"></span>
            </div>


            <!--begin::Info-->
            <div class="d-flex flex-wrap mb-0 mt-2 justify-content-center align-items-baseline" wire:target="addToCart, removeFromCart" wire:loading.class="d-none">
                <!--begin::Budget-->
                @if($added_to_cart)
                    <a href="#" class="btn btn-outline btn-outline-dashed btn-outline-primary disabled">موجود در سبد</a>
                    <div class="mx-2"></div>
                    <a href="#" class="btn btn-link btn-color-danger btn-active-color-primary me-5 mb-2" wire:click.prevent="removeFromCart()">حذف</a>
                @else
                    <button class="btn btn-primary" wire:click.prevent="addToCart()">انتخاب</button>
                @endif
                <!--end::Budget-->
            </div>
            <!--end::Info-->

            <!--begin::Spinner-->
            <div class="d-flex flex-wrap mb-0 mt-2 justify-content-center align-items-baseline d-none" wire:target="addToCart , removeFromCart" wire:loading.class.remove="d-none">
                <span class="spinner-border spinner-border-lg align-middle fw-bolder"></span>
            </div>
            <!--end::Spinner-->

        </div>
        <!--end:: Card body-->
    </div>
    <!--end::Card-->
</div>
