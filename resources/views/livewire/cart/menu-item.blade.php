{{--<div class="d-flex justify-content-between align-items-center">
    <div>
        <div class="fw-semibold fs-2">{{convertNumbers($cart->plan?->title)}}</div>

    </div>
    <div class="d-flex flex-column align-items-end align-content-between justify-content-between">
    </div>
</div>--}}
<div class="d-flex flex-column justify-content-between px-4 py-3 border-gray-200 border-dashed rounded-2 mb-2 bg-hover-light-secondary position-relative">
    <div class="d-flex flex-row justify-content-between">
        <div class="fw-semibold fs-2">{{convertNumbers($cart->plan?->title)}}</div>
        <div class="text-primary fs-4 fw-bolder">{{convertNumbers(number_format($cart->plan?->price))}} {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3 text-primary ms-1') !!} </div>
    </div>
    <div class="d-flex flex-column mt-2">
        <div class="d-flex flex-column mt-2">
            <div class="d-flex">
                <span><i class="fas fa-user"></i></span>
                <div class="mx-1"></div>
                <div>{{convertNumbers($cart->plan?->users_count)}} اشتراک </div>
            </div>
            <div class="my-1"></div>
            <div class="d-flex">
                <span><i class="fas fa-clock"></i></span>
                <div class="mx-1"></div>
                <div>{{convertNumbers($cart->plan?->duration)}} روزه</div>
            </div>
            <div class="my-1"></div>
            <div class="d-flex flex-row">
                <span><i class="fa fa-cloud-arrow-down"></i></span>
                <div class="mx-1"></div>
                <div>
                    @if(is_null($cart->plan?->traffic))
                        نامحدود
                    @else
                        {{convertNumbers(formatBytes($cart->plan?->traffic))}}
                    @endif
                </div>
            </div>

        </div>
    </div>
    <div wire:ignore.self class="cursor-pointer position-absolute bottom-0 end-0 mx-4 my-2" data-bs-toggle="tooltip" data-bs-placement="right" title="حذف" wire:click.prevent="$emit('removeFromCart',{{$cart->id}})"><i class="fas fa-trash text-danger"></i></div>
</div>
