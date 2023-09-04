<div class="flex-column flex-lg-row-auto w-100 w-lg-250px w-xl-300px mb-10">
    <!--begin::Card-->
    <div class="card card-flush pt-3 mb-0" data-kt-sticky="true" data-kt-sticky-name="subscription-summary"
         data-kt-sticky-offset="{default: false, lg: '200px'}" data-kt-sticky-width="{lg: '250px', xl: '300px'}"
         data-kt-sticky-left="auto" data-kt-sticky-top="150px" data-kt-sticky-animation="false"
         data-kt-sticky-zindex="95" style="">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>جزییات پرداخت</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0 fs-6">
            <!--begin::Section-->
            <div class="mb-10">
                <!--begin::Details-->
                <div class="mb-3 d-flex justify-content-between">
                    <div class="">جمع کل</div>
                    <div>{{convertNumbers(number_format($totalPrice))}} {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3 text-dark ms-1') !!}</div>
                </div>

                <div class="mb-3 d-flex justify-content-between">
                    @php
                    $title = '';
                    if ($discount){
                        if ($discount?->plan_id){
                            $plan_title = $discount->plan->title;
                            $title = "$plan_title ($discount->percent%)";
                        }else{
                            $title = "$discount->percent%";
                        }
                        $title = convertNumbers($title);
                        $title = "<span class='badge badge-light-primary'> $title </span>";
                    }
                    @endphp
                    <div class=""> تخفیف {!! $title !!}</div>
                    <div>{{convertNumbers(number_format($discountPrice))}} {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3 text-dark ms-1') !!}</div>
                </div>

                <div class="mb-3 d-flex justify-content-between">
                    <div class="">مبلغ قابل پرداخت</div>
                    <div>{{convertNumbers(number_format($finalPrice))}} {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3 text-dark ms-1') !!}</div>
                </div>
                <!--end::Details-->

            </div>

            <!--end::Section-->
            <!--begin::Separator-->
            <div class="separator separator-dashed mb-8"></div>
            <!--end::Separator-->

            <div class="input-group mb-5">
                <input @if($discount) disabled @endif wire:model.lazy="code" type="text" class="form-control" wire:loading.attr="readonly"
                       wire:target="validateDiscountCode" placeholder="کد تخفیف" aria-label="کد تخفیف"/>
                @error('code')
                <div class="invalid-feedback">{{$message}}</div>
                @enderror
                <button wire:click.prevent="validateDiscountCode()" class="input-group-text @if($discount) text-hover-danger @else text-hover-success @endif">
                    @if($discount)
                        <i class="fas fa-close fs-4" wire:target="validateDiscountCode" wire:loading.class="d-none"></i>
                    @else
                        <i class="fas fa-check fs-4" wire:target="validateDiscountCode" wire:loading.class="d-none"></i>
                    @endif
                    <i class="spinner-border spinner-border-sm fs-4 d-none" wire:target="validateDiscountCode"
                       wire:loading.class.remove="d-none"></i>
                </button>
            </div>

            <!--begin::Actions-->
            <button id="pay" class="btn btn-primary w-100" wire:target="pay" wire:loading.attr="disabled">
                <!--begin::Indicator label-->
                <span class="indicator-label" wire:target="pay" wire:loading.class="d-none">پرداخت</span>
                <!--end::Indicator label-->
                <!--begin::Indicator progress-->
                <span class="d-none" wire:target="pay" wire:loading.class.remove="d-none">
															<span
                                                                class="spinner-border spinner-border-sm align-middle ms-2"
                                                                wire:target="pay"
                                                                wire:loading.class.remove="d-none"></span></span>
                <!--end::Indicator progress-->
            </button>
            <!--end::Actions-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</div>
@push('scripts')
    <script>
        $('#pay').on('click', function () {
            Swal.fire({
                icon: "question",
                title: 'آیا از خرید خود اطمینان دارید؟',
                showCancelButton: true,
                confirmButtonText: 'بله',
                cancelButtonText: `خیر`,
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-secondary",
                }
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                @this.pay();
                }
            })
        })


        document.addEventListener('not-enough-balance', function (data) {
            Swal.fire({
                icon: 'warning',
                title: 'اعتبار ناکافی',
                text: data.detail.message,
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: `افزایش اعتبار`,
                cancelButtonText: `متوجه شدم`,
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-secondary",
                }
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                @this.increaseBalance();
                }
            });
        });

    </script>
@endpush

