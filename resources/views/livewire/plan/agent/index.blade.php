<div xmlns:wire="http://www.w3.org/1999/xhtml" xmlns:livewire="">
    <div class="row g-5 g-xl-10 mb-4 mb-xl-6 mb-xl-10">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-0">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="w-100 d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-1 flex-column justify-content-center my-0">خرید
                        طرح</h1>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Filter menu-->
                    <div class="m-0">
                    <livewire:cart.menu />
                    </div>

                    <livewire:cart.continue-payment-button />
                    <!--end::Filter menu-->
                    <!--begin::Secondary button-->
                    <!--end::Secondary button-->
                    <!--begin::Primary button-->
                    <!--end::Primary button-->
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
    </div>
    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-xl-10">
        <!--begin::Col-->
        <div class="col-sm-4 col-md-4 col-xl-3 col-xxl-4 mb-md-5 mb-xl-10">
            <!--begin::Card Filter-->
            <div class="card mb-5 mb-xl-10">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <div class="card-title">
                        <!--begin::Filter title-->
                        <span class="fs-2 fw-bold text-dark me-2 lh-1 ls-n2">فیلتر</span>
                        <!--end::Filter title-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="card-body d-flex flex-column justify-content-start ">
                    <!--begin::Input group-->
                    <div class="input-group mb-5">
                       <span class="input-group-text">
                           <i class="fas fa-search"></i>
                       </span>
                        <input type="text" class="form-control" placeholder="جستجو" aria-label="جستجو" wire:model.debounce.700ms="search"
                               aria-describedby="basic-addon1"/>
                    </div>
                    <!--end::Input group-->

                    <div class="separator border-gray-200"></div>
                    <!--begin::Input Range group-->

                    <!--end::Input Range group-->

                    <div class="separator border-gray-200"></div>

                    <!--begin::Accordion-->
                    <div wire:ignore class="accordion border-none mt-5 mb-5" id="kt_accordion_1">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="kt_accordion_1_header_1">
                                <button class="accordion-button fs-4 fw-semibold collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_1"
                                        aria-expanded="true" aria-controls="kt_accordion_1_body_1">
                                    محدوده قیمت
                                </button>
                            </h2>
                            <div id="kt_accordion_1_body_1" class="accordion-collapse collapse"
                                 aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                <div class="accordion-body">
                                    <div class="mb-5">
                                        <div class="d-flex flex-column mt-12" dir="ltr">
                                            <div id="price-slider" class="noUi-sm"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-1 flex-row-reverse">
                                            <span class="text-muted">ارزانترین</span>
                                            <span class="text-muted">گرانترین</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Accordion-->

                    <div class="separator border-gray-200"></div>

                    <!--begin::Accordion-->
                    <div wire:ignore class="accordion border-none mt-5 mb-5" id="kt_accordion_2">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="kt_accordion_2_header_2">
                                <button class="accordion-button fs-4 fw-semibold collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#kt_accordion_2_body_2"
                                        aria-expanded="true" aria-controls="kt_accordion_2_body_2">
                                    محدوده کاربر
                                </button>
                            </h2>
                            <div id="kt_accordion_2_body_2" class="accordion-collapse collapse"
                                 aria-labelledby="kt_accordion_2_header_2" data-bs-parent="#kt_accordion_2">
                                <div class="accordion-body">
                                    <div class="mb-5">
                                        <div class="d-flex flex-column mt-12" dir="ltr">
                                            <div id="user-count-slider" class="noUi-sm"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-1 flex-row-reverse">
                                            <span class="text-muted">کمترین</span>
                                            <span class="text-muted">بیشترین</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Accordion-->

                    <div class="separator border-gray-200"></div>

                    <!--begin::Accordion-->
                    <div wire:ignore class="accordion border-none mt-5 mb-5" id="kt_accordion_3">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="kt_accordion_3_header_3">
                                <button class="accordion-button fs-4 fw-semibold collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#kt_accordion_3_body_3"
                                        aria-expanded="true" aria-controls="kt_accordion_3_body_3">
                                    محدوده زمانی (روز)
                                </button>
                            </h2>
                            <div id="kt_accordion_3_body_3" class="accordion-collapse collapse"
                                 aria-labelledby="kt_accordion_3_header_3" data-bs-parent="#kt_accordion_3">
                                <div class="accordion-body">
                                    <div class="mb-5">
                                        <div class="d-flex flex-column mt-12" dir="ltr">
                                            <div id="duration-slider" class="noUi-sm"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-1 flex-row-reverse">
                                            <span class="text-muted">کمترین</span>
                                            <span class="text-muted">بیشترین</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Accordion-->

                    <div class="separator border-gray-200"></div>

                    <div class="mt-5">
                        <label class="form-check-label fs-3 fw-bold mb-3" for="flexSwitchDefault">
                            محدودیت حجم
                        </label>
                        <div class="form-check form-switch form-check-custom form-check-solid my-2">
                            <input class="form-check-input" type="checkbox" wire:model.defer="lessThan5GB" onchange="@this.putValue('lessThan5GB',event.target.checked)"/>
                            <label class="form-check-label">
                                کمتر از ۵ گیگابایت
                            </label>
                        </div>

                        <label class="form-check form-switch form-check-custom form-check-solid my-2">
                            <input class="form-check-input" type="checkbox" wire:model.defer="between5to10GB" onchange="@this.putValue('between5to10GB',event.target.checked)"/>
                            <span class="form-check-label">
                            ۵ گیگابایت تا ۱۰ گیگابایت
                            </span>
                        </label>

                        <div class="form-check form-switch form-check-custom form-check-solid my-2">
                            <input class="form-check-input" type="checkbox" wire:model.defer="between10to20GB" onchange="@this.putValue('between10to20GB',event.target.checked)"/>
                            <label class="form-check-label">
                                ۱۰ گیگابایت تا ۲۰ گیگابایت
                            </label>
                        </div>

                        <div class="form-check form-switch form-check-custom form-check-solid my-2">
                            <input class="form-check-input" type="checkbox" wire:model.defer="between20to50GB" onchange="@this.putValue('between20to50GB',event.target.checked)"/>
                            <label class="form-check-label">
                                ۲۰ گیگابایت تا ۵۰ گیگابایت
                            </label>
                        </div>
                        <div class="form-check form-switch form-check-custom form-check-solid my-2">
                            <input class="form-check-input" type="checkbox" wire:model.defer="between50to100GB" onchange="@this.putValue('between50to100GB',event.target.checked)"/>
                            <label class="form-check-label">
                                ۵۰ گیگابایت تا ۱۰۰ گیگابایت
                            </label>
                        </div>
                        <div class="form-check form-switch form-check-custom form-check-solid my-2">
                            <input class="form-check-input" type="checkbox" wire:model.defer="greaterThan100GB" onchange="@this.putValue('greaterThan100GB',event.target.checked)"/>
                            <label class="form-check-label">
                                بیشتر از ۱۰۰ گیگابایت
                            </label>
                        </div>
                    </div>

                </div>
                <!--end::Card body-->
                <div class="card-footer">
                    <div class="d-flex justify-content-start">
                        <button id="resetFilter" class="btn btn-secondary mx-1" wire:click="resetFilter()">حذف فیلتر</button>
{{--                        <button class="btn btn-primary mx-1">اعمال</button>--}}
                    </div>
                </div>
            </div>
            <!--end::Card Filter-->
        </div>
        <!--end::Col-->


        <!--begin::Col-->
        <div class="col-sm-8 col-md-8 col-xl-9 col-xxl-8 mb-5 mb-xl-0">
            <div class="h-100 w-100 d-none" wire:target="previousPage, nextPage, gotoPage, search , resetFilter,putValue" wire:loading.class.remove="d-none">
            <div class="d-flex flex-column align-items-center justify-content-center h-100">
                <span class="spinner-border spinner-border-lg align-middle ms-2 fw-bolder"></span>
            </div>
            </div>
            <div wire:target="previousPage, nextPage, gotoPage, search , resetFilter,putValue" wire:loading.class="d-none">
                @if($plans->count())
            <div class="row">
                @foreach($plans as $plan)
               <livewire:plan.agent.plan-item :plan="$plan" :wire:key="$plan->id"/>
                @endforeach
            </div>
                @else
                   <div class="h-100 w-100">
                       <div class="d-flex flex-column align-items-center justify-content-center">
                           <span class="fs-bold h3">طرحی پیدا نشد</span>
                       </div>
                   </div>
                @endif
            </div>
        </div>
        <!--end::Col-->
        {{$plans->links()}}
    </div>
    <!--end::Row-->

</div>

@push('scripts')
    <script>

        document.addEventListener('livewire:load',function (){

            var priceSlider = document.getElementById('price-slider');

            var priceRange = @this.priceRange;

            var priceSliderOptions = {
                start: [priceRange[0], priceRange[1]],
                step: 1,
                range: {
                    'min': priceRange[0],
                    'max': priceRange[1]
                },
                tooltips: [wNumb({decimals: 0}), wNumb({decimals: 0})]
            };

            noUiSlider.create(priceSlider, priceSliderOptions);

            priceSlider.noUiSlider.on('set', (values,handleNumber,unencoded) => {
            @this.putValue('priceRange',unencoded);
            });

            var userCountSlider = document.getElementById('user-count-slider');

            var userCountRange = @this.userCountRange;

            var userCountSliderOptions = {
                start: [userCountRange[0], userCountRange[1]],
                step: 1,
                range: {
                    'min': userCountRange[0],
                    'max': userCountRange[1]
                },
                tooltips: [wNumb({decimals: 0}), wNumb({decimals: 0})]
            };

            noUiSlider.create(userCountSlider, userCountSliderOptions);

            userCountSlider.noUiSlider.on('set', (values,handleNumber,unencoded) => {
            @this.putValue('userCountRange',unencoded);
            });


            var durationSlider = document.getElementById('duration-slider');

            var durationRange = @this.durationRange;

            var durationSliderOptions = {
                start: [durationRange[0], durationRange[1]],
                step: 1,
                range: {
                    'min': durationRange[0],
                    'max': durationRange[1]
                },
                tooltips: [wNumb({decimals: 0}), wNumb({decimals: 0})]
            };

            noUiSlider.create(durationSlider, durationSliderOptions);

            durationSlider.noUiSlider.on('set', (values,handleNumber,unencoded) => {
            @this.putValue('durationRange',unencoded);
            });

            $('#resetFilter').on('click',function (event) {
                priceSlider.noUiSlider.updateOptions(priceSliderOptions,true);
                userCountSlider.noUiSlider.updateOptions(userCountSliderOptions,true);
                durationSlider.noUiSlider.updateOptions(durationSliderOptions,true);
            })

        });


    </script>
@endpush
@section('title')
    خرید طرح
@endsection
@section('description')
    خرید طرح
@endsection