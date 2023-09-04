<div class="card card-flush pt-3 mb-5 mb-lg-10">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Card title-->
        <div class="card-title">
            <h2 class="fw-bold">طرح های انتخاب شده</h2>
        </div>
        <!--begin::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <a href="{{route('plans.buy')}}" type="button" class="btn btn-light-primary">افزودن طرح
            </a>
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0">
        <!--begin::Table wrapper-->
        <div class="table-responsive">
            <!--begin::Table-->
            <div id="kt_subscription_products_table_wrapper"
                 class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <table
                        class="table align-middle table-row-dashed fs-6 fw-semibold gy-4 dataTable no-footer"
                        id="kt_subscription_products_table">
                        <!--begin::Table head-->
                        <thead>
                        <tr class="text-start text-gray-900 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-300px sorting_disabled" rowspan="1" colspan="1"
                                style="width: 379px;">نام طرح
                            </th>
                            <th class="min-w-100px sorting_disabled" rowspan="1" colspan="1"
                                style="width: 130px;">تعداد کاربر
                            </th>
                            <th class="min-w-100px sorting_disabled" rowspan="1" colspan="1"
                                style="width: 130px;">مدت زمان طرح
                            </th>
                            <th class="min-w-150px sorting_disabled" rowspan="1" colspan="1"
                                style="width: 193px;">ترافیک
                            </th>
                            <th class="min-w-150px sorting_disabled" rowspan="1" colspan="1"
                                style="width: 193px;">قیمت
                            </th>
                            <th class="min-w-70px text-end sorting_disabled" rowspan="1" colspan="1"
                                style="width: 70px;">
                            </th>
                        </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-800">
                            @foreach($carts as $cart)
                                <livewire:cart.summary.cart-table-item :cart="$cart" :wire:key="$cart->id"/>
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
                <div class="row">
                    <div
                        class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"></div>
                    <div
                        class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"></div>
                </div>
            </div>
            <!--end::Table-->
        </div>
        <!--end::Table wrapper-->
    </div>
    <!--end::Card body-->
</div>
