<div>
    <!--begin::Menu toggle-->
    <button wire:ignore.self
            class="btn btn-icon btn-flex bg-body btn-color-gray-700 btn-active-color-primary fw-bold position-relative "
            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0,15"
            data-bs-toggle="tooltip" data-bs-placement="top" title="سبد خرید">
        <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
        <i class="fas fa-bag-shopping"></i>
        <span
                class="position-absolute top-0 start-0 translate-middle badge badge-circle badge-primary">{{convertNumbers($carts->count())}}</span>
        {{--                                  {!! get_svg_icon('icons/duotune/Shopping/Cart4.svg','svg-icon svg-icon-2x svg-icon-muted me-1') !!}--}}
        <!--end::Svg Icon--></button>
    <!--end::Menu toggle-->
    <!--begin::Menu 1-->
    <div wire:ignore.self class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true">
        <!--begin::Header-->
        <div class="d-flex flex-row justify-content-between align-items-center px-4 py-5">
            <div class="d-flex flex-center fs-4 text-dark fw-bold">سبد خرید شما</div>
            @if($carts->count())
                <button type="reset" class="btn btn-sm btn-icon btn-light btn-active-light-secondary"
                        data-kt-menu-dismiss="true" wire:click.prevent="emptyCart()"><i class="fas fa-trash text-gray-700"></i></button>
            @endif
        </div>
        <!--end::Header-->
        <!--begin::Menu separator-->
        <div class="separator border-gray-200"></div>
        <!--end::Menu separator-->
        <!--begin::Form-->
        <div wire:ignore.self class="px-2 py-2 scroll" data-kt-scroll="true"
             data-kt-scroll-height="{default: '250px', lg: '250px'}" id="menu-scroll">
            @php
                $carts = auth()->user()->cart()->get();
                $totalPrice = 0;
            @endphp
            @if($carts->count())
                @foreach($carts as $cart)
                    <!--begin::Cart Item-->
                    <livewire:cart.menu-item :cart="$cart" :wire:key="$cart->id"/>
                    @php $totalPrice+=$cart->plan->price; @endphp
                    <!--end::Cart Item-->
                @endforeach
            @else
                <!--begin::Cart Empty-->
                <div
                        class="d-flex flex-column justify-content-center align-items-center px-4 py-3 border-gray-200 mb-2">
                    <div class="mb-2">
                        سبد خرید خالی است
                    </div>
                    <div>
                        <a href="{{route('plans.buy')}}" class="text-primary fw-bold">مشاهده پلن ها</a>
                    </div>
                    <div class="text-center px-4">
                        <img class="mw-100 mh-150px" alt="image"
                             src="{{asset(theme()->isDarkModeEnabled() ? 'media/illustrations/sigma-1/11-dark.png' : 'media/illustrations/sigma-1/11.png')}}">
                    </div>
                </div>
                <!--end::Cart Empty-->
            @endif


        </div>
        <!--begin::Menu separator-->
        <div class="separator border-gray-200"></div>
        <!--end::Menu separator-->
        <div class="my-2">
            <div class="d-flex align-items-center justify-content-between my-2 px-4">
                <span class="dark:text-white text-dark-550 font-normal text-lg">جمع کل :</span>
                <span class="flex items-center dark:text-white text-dark-550 font-medium text-xl">
                    {{convertNumbers(number_format($totalPrice))}}
                    {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3 text-dark ms-1') !!}
                </span>
            </div>
        </div>
        @if($carts->count())
            <!--begin::Menu separator-->
            <div class="separator border-gray-200"></div>
            <!--end::Menu separator-->
            <div class="my-2">
                <div class="d-flex px-4">
                    <a href="{{route('carts.index')}}" class="btn btn-sm btn-primary w-100" data-kt-menu-dismiss="true">
                        ادامه جهت پرداخت
                    </a>
                </div>
            </div>
        @endif

        <!--end::Form-->
    </div>
    <!--end::Menu 1-->
</div>

@push('scripts')
    <script>

    </script>
@endpush
