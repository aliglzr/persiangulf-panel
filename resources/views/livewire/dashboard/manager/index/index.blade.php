@php use App\Models\User; @endphp
<div class="container-xxl">
    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">

            <!--begin::Card widget 4-->
            <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <div class="card-title d-flex flex-column">
                        <!--begin::Info-->
                        <div class="d-flex align-items-center">
                            <!--begin::Amount-->
                            <span
                                class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{convertNumbers(number_format(User::role('client')->count()))}}</span>
                            <!--end::Amount-->

                            <!--begin::Currency-->
                            <span class="fs-8 fw-semibold text-gray-400 me-1 align-self-end">مشتری کل</span>
                            <!--end::Currency-->

                            <!--begin::Badge-->
                            <span
                                class="badge badge-light-{{$monthlyClientIncrease == 0 ? 'secondary' : ($monthlyClientIncrease > 0 ? 'success' : 'danger')}} fs-base"
                                dir="ltr">
                    <i class="ki-duotone ki-arrow-up fs-5 text-{{$monthlyClientIncrease == 0 ? 'secondary' : ($monthlyClientIncrease > 0 ? 'success' : 'danger')}} ms-n1"><span
                            class="path1"></span><span
                            class="path2"></span></i>
                    {{convertNumbers($monthlyClientIncrease)}}%
                </span>
                            <!--end::Badge-->
                        </div>
                        <!--end::Info-->

                        <!--begin::Subtitle-->
                        <span class="text-gray-400 pt-1 fw-semibold fs-6">تعداد مشتریان در هر لایه</span>
                        <!--end::Subtitle-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Header-->

                <!--begin::Card body-->
                <div class="card-body pb-4 d-flex align-items-center">
                    <!--begin::Labels-->
                    <div class="d-flex flex-column content-justify-center w-100">
                        @foreach(\App\Models\Layer::where('active', true)->get() as $layer)
                            <!--begin::Label-->
                            <div class="d-flex fs-6 fw-semibold align-items-center mb-1">
                                <!--begin::Bullet-->
                                <div class="bullet w-8px h-8px rounded-2 bg-danger me-3"
                                     style="background-color: {{string_to_color($layer->name)}} !important;"></div>
                                <!--end::Bullet-->

                                <!--begin::Label-->
                                <div class="text-gray-500 flex-grow-1 me-4">{{$layer->name}}</div>
                                <!--end::Label-->

                                <!--begin::Stats-->
                                <div
                                    class="fw-bolder text-gray-700 text-xxl-end">{{convertNumbers(number_format($layer->users()->count()))}}
                                    مشتری
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Label-->
                        @endforeach
                    </div>
                    <!--end::Labels-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card widget 4-->

            <!--begin::Card widget 5-->
            <div class="card card-flush h-md-50 mb-xl-10">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <div class="card-title d-flex flex-column">
                        <!--begin::Info-->
                        <div class="d-flex align-items-center">
                            <!--begin::Amount-->
                            <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">1,836</span>
                            <!--end::Amount-->

                            <!--begin::Badge-->
                            <span class="badge badge-light-danger fs-base">
                    <i class="ki-duotone ki-arrow-down fs-5 text-danger ms-n1"><span class="path1"></span><span
                            class="path2"></span></i>
                    2.2%
                </span>
                            <!--end::Badge-->
                        </div>
                        <!--end::Info-->

                        <!--begin::Subtitle-->
                        <span class="text-gray-400 pt-1 fw-semibold fs-6">Orders This Month</span>
                        <!--end::Subtitle-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Header-->

                <!--begin::Card body-->
                <div class="card-body d-flex align-items-end pt-0">
                    <!--begin::Progress-->
                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                        <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                            <span class="fw-bolder fs-6 text-dark">1,048 to Goal</span>
                            <span class="fw-bold fs-6 text-gray-400">62%</span>
                        </div>

                        <div class="h-8px mx-3 w-100 bg-light-success rounded">
                            <div class="bg-success rounded h-8px" role="progressbar" style="width: 62%;"
                                 aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end::Progress-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card widget 5-->    </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">

            <!--begin::Card widget 4-->
            <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <div class="card-title d-flex flex-column">
                        <!--begin::Info-->
                        <div class="d-flex align-items-center">
                            @php
                                $totalClientsCount = User::role('client')->join('subscriptions', 'users.id', '=', 'subscriptions.user_id')
                                                ->where('subscriptions.using', true)
                                                ->distinct('users.id')
                                                ->count('users.id');
                            @endphp
                                <!--begin::Amount-->
                            <span
                                class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{convertNumbers(number_format($totalClientsCount))}}</span>
                            <!--end::Amount-->

                            <!--begin::Currency-->
                            <span class="fs-8 fw-semibold text-gray-400 me-1 align-self-end">مشتری فعال کل</span>
                            <!--end::Currency-->
                        </div>
                        <!--end::Info-->

                        <!--begin::Subtitle-->
                        <span class="text-gray-400 pt-1 fw-semibold fs-6">تعداد مشتریان فعال در هر لایه</span>
                        <!--end::Subtitle-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Header-->

                <!--begin::Card body-->
                <div class="card-body pb-4 d-flex align-items-center">
                    <!--begin::Labels-->
                    <div class="d-flex flex-column content-justify-center w-100">
                        @foreach(\App\Models\Layer::where('active', true)->get() as $layer)
                            <!--begin::Label-->
                            <div class="d-flex fs-6 fw-semibold align-items-center mb-1">
                                <!--begin::Bullet-->
                                <div class="bullet w-8px h-8px rounded-2 bg-danger me-3"
                                     style="background-color: {{string_to_color($layer->name)}} !important;"></div>
                                <!--end::Bullet-->

                                <!--begin::Label-->
                                <div class="text-gray-500 flex-grow-1 me-4">{{$layer->name}}</div>
                                <!--end::Label-->
                                @php
                                    $clientsCount = User::role('client')->join('subscriptions', 'users.id', '=', 'subscriptions.user_id')
                                                    ->where('subscriptions.using', true)
                                                    ->where('users.layer_id', $layer->id)
                                                    ->distinct('users.id')
                                                    ->count('users.id');
                                @endphp
                                    <!--begin::Stats-->
                                <div
                                    class="fw-bolder text-gray-700 text-xxl-end">{{convertNumbers(number_format($clientsCount))}}
                                    مشتری
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Label-->
                        @endforeach
                    </div>
                    <!--end::Labels-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card widget 4-->


            <!--begin::Card widget 7-->
            <div class="card card-flush h-md-50 mb-xl-10">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <div class="card-title d-flex flex-column">
                        <!--begin::Info-->
                        <div class="d-flex align-items-center">
                            @php
                                $totalBotClientsCount = User::role('client')->where('from_bot', true)->count();
                            @endphp
                                <!--begin::Amount-->
                            <span
                                class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{convertNumbers(number_format($totalBotClientsCount))}}</span>
                            <!--end::Amount-->

                            <!--begin::Currency-->
                            <span class="fs-8 fw-semibold text-gray-400 me-1 align-self-end">مشتری کل</span>
                            <!--end::Currency-->
                        </div>
                        <!--end::Info-->

                        <!--begin::Subtitle-->
                        <span class="text-gray-400 pt-1 fw-semibold fs-6">تعداد کاربران ربات</span>
                        <!--end::Subtitle-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Header-->

                <!--begin::Card body-->
                <div class="card-body d-flex align-items-end pt-0">
                    @php
                        $currentClients = $totalBotClientsCount;
                        // Calculate the next goal point
                        $nextGoalPoint = ceil($currentClients / 1000) * 1000;

                        // Calculate the progress percentage
                        $progress = ($currentClients / $nextGoalPoint) * 100;

                        // Round the progress to two decimal places
                        $progress = round($progress, 2);
                    @endphp
                    <!--begin::Progress-->
                    <div class="d-flex align-items-center flex-column mt-3 w-100">
                        <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                            <span class="fw-bolder fs-6 text-dark">{{convertNumbers(number_format($nextGoalPoint - $currentClients))}} مشتری تا هدف</span>
                            <span class="fw-bold fs-6 text-gray-400">{{convertNumbers($progress)}}٪</span>
                        </div>

                        <div class="h-8px mx-3 w-100 bg-light-success rounded">
                            <div class="bg-success rounded h-8px" role="progressbar" style="width: {{$progress}}%;"
                                 aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end::Progress-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card widget 7-->
        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0">
            <!--begin::Chart widget 3-->
            <div class="card card-flush overflow-hidden h-md-100">
                <!--begin::Header-->
                <div class="card-header py-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">فروش ماهیانه</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">مقدار فروش این ماه</span>
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->

                <!--begin::Card body-->
                <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
                    <!--begin::Statistics-->
                    <div class="px-9 mb-5">
                        <!--begin::Statistics-->
                        <div class="d-flex mb-2">
                            <span
                                class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{convertNumbers(number_format($thisMonthTotalSells))}}</span>
                            <span class="fs-4 fw-semibold text-gray-400 me-1">تومان</span>
                        </div>
                        <!--end::Statistics-->

                        <!--begin::Description-->
                        <span
                            class="fs-6 fw-semibold text-gray-400">فروش کل ماه {{now()->locale("en")->monthName}}</span>
                        <!--end::Description-->
                    </div>
                    <!--end::Statistics-->
                    <!--begin::Statistics-->
                    <div class="px-9 mb-5">
                        <!--begin::Statistics-->
                        <div class="d-flex mb-2">
                            <span
                                class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{convertNumbers(number_format($totalNotSettledIncome))}}</span>
                            <span class="fs-4 fw-semibold text-gray-400 me-1">تومان</span>
                        </div>
                        <!--end::Statistics-->

                        <!--begin::Description-->
                        <span
                            class="fs-6 fw-semibold text-gray-400">درآمد کل تصفیه نشده</span>
                        <!--end::Description-->
                    </div>
                    <!--end::Statistics-->

                    <!--begin::Chart-->
                    <div id="month_sales_chart" class="min-h-auto ps-4 pe-6"
                         style="height: 300px; min-height: 315px;"></div>
                    <!--end::Chart-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Chart widget 3-->    </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->

    <!--begin::Row-->
    <div class="row gy-5 g-xl-10">
        <!--begin::Col-->
        <div class="col-xl-6 mb-xl-10">

            <!--begin::Table widget 2-->
            <div class="card h-md-100">
                <!--begin::Header-->
                <div class="card-header align-items-center border-0">
                    <div class="card-title align-items-start flex-column pt-5">
                        <!--begin::Title-->
                        <h3 class="fw-bold text-gray-900 m-0">نمایندگان برتر</h3>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">بر اساس تعداد مشتری</span>
                        <!--end::Title-->
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body pt-2">

                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                            <!--begin::Table head-->
                            <thead>
                            <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                <th class="ps-0 w-50px">رتبه</th>
                                <th class="min-w-125px">نام کاربری</th>
                                <th class="text-end min-w-100px">تعداد مشتری</th>
                                <th class="pe-0 text-end min-w-100px">مشتری فعال</th>
                                <th class="pe-0 text-end min-w-100px">خرید کل</th>
                            </tr>
                            </thead>
                            <!--end::Table head-->

                            <!--begin::Table body-->
                            <tbody>
                            @foreach($bestThreeAgents as $key => $agent)
                                <tr>
                                    <td>
                                        {{convertNumbers($key+1)}}
                                    </td>
                                    <td class="ps-0">
                                        <a href="{{route('agents.overview',$agent->id)}}"
                                           class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6 text-start pe-0">{{$agent->full_name}}</a>
                                        <span
                                            class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">{{$agent->username}}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-gray-800 fw-bold d-block fs-6 ps-0 text-end">{{convertNumbers($agent->introduced()->count())}}</span>
                                    </td>
                                    <td class="text-end pe-0">
                                        <span class="text-gray-800 fw-bold d-block fs-6">{{convertNumbers($agent->introduced()->join('subscriptions', 'users.id', '=', 'subscriptions.user_id')
                                            ->where('subscriptions.using', true)
                                            ->distinct('users.id')
                                            ->count('users.id'))}}</span>
                                    </td>
                                    <td class="text-end pe-0">
                                        <span class="text-gray-800 fw-bold d-block fs-6">{{convertNumbers(number_format($agent->payments()->where('status', 'paid')->whereNotNull('reference_id')->sum('amount')))}} تومان</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Table container-->
                </div>
                <!--end: Card Body-->
            </div>
            <!--end::Table widget 2-->    </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-xl-6 mb-xl-10">

            <!--begin::Table widget 2-->
            <div class="card h-md-100">
                <!--begin::Header-->
                <div class="card-header align-items-center border-0">
                    <div class="card-title align-items-start flex-column pt-5">
                        <!--begin::Title-->
                        <h3 class="fw-bold text-gray-900 m-0">نمایندگان برتر</h3>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">بر اساس تعداد مشتری فعال</span>
                        <!--end::Title-->
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body pt-2">

                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-row-dashed align-middle gs-0 gy-4 my-0">
                            <!--begin::Table head-->
                            <thead>
                            <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                                <th class="ps-0 w-50px">رتبه</th>
                                <th class="min-w-125px">نام کاربری</th>
                                <th class="text-end min-w-100px">تعداد مشتری</th>
                                <th class="pe-0 text-end min-w-100px">مشتری فعال</th>
                                <th class="pe-0 text-end min-w-100px">خرید کل</th>
                            </tr>
                            </thead>
                            <!--end::Table head-->

                            <!--begin::Table body-->
                            <tbody>
                            @foreach($bestThreeAgentsByActiveClients as $key => $agent)
                                <tr>
                                    <td>
                                        {{convertNumbers($key+1)}}
                                    </td>
                                    <td class="ps-0">
                                        <a href="{{route('agents.overview',$agent->id)}}"
                                           class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6 text-start pe-0">{{$agent->full_name}}</a>
                                        <span
                                            class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0">{{$agent->username}}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-gray-800 fw-bold d-block fs-6 ps-0 text-end">{{convertNumbers($agent->introduced()->count())}}</span>
                                    </td>
                                    <td class="text-end pe-0">
                                        <span class="text-gray-800 fw-bold d-block fs-6">{{convertNumbers($agent->introduced()->join('subscriptions', 'users.id', '=', 'subscriptions.user_id')
                                            ->where('subscriptions.using', true)
                                            ->distinct('users.id')
                                            ->count('users.id'))}}</span>
                                    </td>
                                    <td class="text-end pe-0">
                                        <span class="text-gray-800 fw-bold d-block fs-6">{{convertNumbers(number_format($agent->payments()->where('status', 'paid')->whereNotNull('reference_id')->sum('amount')))}} تومان</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Table container-->
                </div>
                <!--end: Card Body-->
            </div>
            <!--end::Table widget 2-->    </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->

    <!--begin::Row-->
    <div class="row gy-5 g-xl-10">
        <!--begin::Col-->
        <div class="col-xl-4 mb-xl-10">

            <!--begin::Engage widget 1-->
            <div class="card h-md-100" dir="ltr">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column flex-center">
                    <!--begin::Heading-->
                    <div class="mb-2">
                        <!--begin::Title-->
                        <h1 class="fw-semibold text-gray-800 text-center lh-lg">
                            Have you tried <br> new
                            <span class="fw-bolder"> eCommerce App ?</span>
                        </h1>
                        <!--end::Title-->

                        <!--begin::Illustration-->
                        <div class="py-10 text-center">
                            <img src="/metronic8/demo1/assets/media/svg/illustrations/easy/2.svg"
                                 class="theme-light-show w-200px" alt="">
                            <img src="/metronic8/demo1/assets/media/svg/illustrations/easy/2-dark.svg"
                                 class="theme-dark-show w-200px" alt="">
                        </div>
                        <!--end::Illustration-->
                    </div>
                    <!--end::Heading-->

                    <!--begin::Links-->
                    <div class="text-center mb-1">
                        <!--begin::Link-->
                        <a class="btn btn-sm btn-primary me-2"
                           href="/metronic8/demo1/../demo1/apps/ecommerce/sales/listing.html">
                            View App </a>
                        <!--end::Link-->

                        <!--begin::Link-->
                        <a class="btn btn-sm btn-light"
                           href="/metronic8/demo1/../demo1/apps/ecommerce/catalog/add-product.html">
                            New Product </a>
                        <!--end::Link-->
                    </div>
                    <!--end::Links-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Engage widget 1-->

        </div>
        <!--end::Col-->

        <!--begin::Col-->
        <div class="col-xl-8 mb-5 mb-xl-10">

            <!--begin::Package Sells Chart -->
            <div class="card card-flush overflow-hidden h-md-100">
                <!--begin::Header-->
                <div class="card-header py-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">نمودار تعداد ثبت اشتراک</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">بر اساس هر بسته</span>
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->

                <!--begin::Card body-->
                <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
                    <!--begin::Info-->
                    <div class="px-9 mb-5">
                        <!--begin::Statistics-->
                        <div class="d-flex align-items-center mb-2">

                            <!--begin::Value-->
                            <span
                                class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{convertNumbers(number_format($thisMonthSubscriptions))}}</span>
                            <!--end::Value-->

                            <!--begin::Currency-->
                            <span class="fs-4 fw-semibold text-gray-400 align-self-start me-1">اشتراک</span>
                            <!--end::Currency-->

                            <!--begin::Label-->
                            <span
                                class="badge badge-light-{{$monthlySubscriptionIncrease == 0 ? 'secondary' : ($monthlySubscriptionIncrease > 0 ? 'success' : 'danger')}} fs-base"
                                dir="ltr">
                    <i class="ki-duotone ki-arrow-up fs-5 text-{{$monthlySubscriptionIncrease == 0 ? 'secondary' : ($monthlySubscriptionIncrease > 0 ? 'success' : 'danger')}} ms-n1"><span
                            class="path1"></span><span
                            class="path2"></span></i>
                    {{convertNumbers($monthlySubscriptionIncrease)}}%
                </span>
                            <!--end::Label-->
                        </div>
                        <!--end::Statistics-->

                        <!--begin::Description-->
                        <span class="fs-6 fw-semibold text-gray-400">تعداد اشتراک های خریداری شده این ماه</span>
                        <!--end::Description-->
                    </div>
                    <!--end::Info-->

                    <!--begin::Chart-->
                    <div id="package_sells_chart" class="min-h-auto ps-4 pe-6"
                         style="height: 300px; min-height: 315px;"></div>
                    <!--end::Chart-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Package Sells Chart-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->

    <!--begin::Row-->
    <div class="row gy-5 g-xl-10">
        <!--begin::Col-->
        <div class="col-xl-4">

            <!--begin::List widget 5-->
            <div class="card card-flush h-xl-100">
                <!--begin::Header-->
                <div class="card-header pt-7">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">Product Delivery</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">1M Products Shipped so far</span>
                    </h3>
                    <!--end::Title-->

                    <!--begin::Toolbar-->
                    <div class="card-toolbar">
                        <a href="/metronic8/demo1/../demo1/apps/ecommerce/sales/details.html"
                           class="btn btn-sm btn-light">Order Details</a>
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body">
                    <!--begin::Scroll-->
                    <div class="hover-scroll-overlay-y pe-6 me-n6" style="height: 415px">
                        <!--begin::Item-->
                        <div class="border border-dashed border-gray-300 rounded px-7 py-3 mb-6">
                            <!--begin::Info-->
                            <div class="d-flex flex-stack mb-3">
                                <!--begin::Wrapper-->
                                <div class="me-3">
                                    <!--begin::Icon-->
                                    <img src="/metronic8/demo1/assets/media/stock/ecommerce/210.gif"
                                         class="w-50px ms-n1 me-1" alt="">
                                    <!--end::Icon-->

                                    <!--begin::Title-->
                                    <a href="/metronic8/demo1/../demo1/apps/ecommerce/catalog/edit-product.html"
                                       class="text-gray-800 text-hover-primary fw-bold">Elephant 1802</a>
                                    <!--end::Title-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Action-->
                                <div class="m-0">
                                    <!--begin::Menu-->
                                    <button
                                        class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                        data-kt-menu-overflow="true">

                                        <i class="ki-duotone ki-dots-square fs-1"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span></i>
                                    </button>

                                    <!--begin::Menu 2-->
                                    <div
                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Quick Actions
                                            </div>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <div class="separator mb-3 opacity-75"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Ticket
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Customer
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                             data-kt-menu-placement="right-start">
                                            <!--begin::Menu item-->
                                            <a href="#" class="menu-link px-3">
                                                <span class="menu-title">New Group</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <!--end::Menu item-->

                                            <!--begin::Menu sub-->
                                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Admin Group
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Staff Group
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Member Group
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu sub-->
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Contact
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <div class="separator mt-3 opacity-75"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content px-3 py-3">
                                                <a class="btn btn-primary  btn-sm px-4" href="#">
                                                    Generate Reports
                                                </a>
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 2-->

                                    <!--end::Menu-->
                                </div>
                                <!--end::Action-->
                            </div>
                            <!--end::Info-->

                            <!--begin::Customer-->
                            <div class="d-flex flex-stack">
                                <!--begin::Name-->
                                <span class="text-gray-400 fw-bold">To:
                            <a href="/metronic8/demo1/../demo1/apps/ecommerce/sales/details.html"
                               class="text-gray-800 text-hover-primary fw-bold">
                                Jason Bourne                            </a>
                        </span>
                                <!--end::Name-->

                                <!--begin::Label-->
                                <span class="badge badge-light-success">Delivered</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Customer-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="border border-dashed border-gray-300 rounded px-7 py-3 mb-6">
                            <!--begin::Info-->
                            <div class="d-flex flex-stack mb-3">
                                <!--begin::Wrapper-->
                                <div class="me-3">
                                    <!--begin::Icon-->
                                    <img src="/metronic8/demo1/assets/media/stock/ecommerce/209.gif"
                                         class="w-50px ms-n1 me-1" alt="">
                                    <!--end::Icon-->

                                    <!--begin::Title-->
                                    <a href="/metronic8/demo1/../demo1/apps/ecommerce/catalog/edit-product.html"
                                       class="text-gray-800 text-hover-primary fw-bold">RiseUP</a>
                                    <!--end::Title-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Action-->
                                <div class="m-0">
                                    <!--begin::Menu-->
                                    <button
                                        class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                        data-kt-menu-overflow="true">

                                        <i class="ki-duotone ki-dots-square fs-1"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span></i>
                                    </button>

                                    <!--begin::Menu 2-->
                                    <div
                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Quick Actions
                                            </div>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <div class="separator mb-3 opacity-75"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Ticket
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Customer
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                             data-kt-menu-placement="right-start">
                                            <!--begin::Menu item-->
                                            <a href="#" class="menu-link px-3">
                                                <span class="menu-title">New Group</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <!--end::Menu item-->

                                            <!--begin::Menu sub-->
                                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Admin Group
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Staff Group
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Member Group
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu sub-->
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Contact
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <div class="separator mt-3 opacity-75"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content px-3 py-3">
                                                <a class="btn btn-primary  btn-sm px-4" href="#">
                                                    Generate Reports
                                                </a>
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 2-->

                                    <!--end::Menu-->
                                </div>
                                <!--end::Action-->
                            </div>
                            <!--end::Info-->

                            <!--begin::Customer-->
                            <div class="d-flex flex-stack">
                                <!--begin::Name-->
                                <span class="text-gray-400 fw-bold">To:
                            <a href="/metronic8/demo1/../demo1/apps/ecommerce/sales/details.html"
                               class="text-gray-800 text-hover-primary fw-bold">
                                Marie Durant                            </a>
                        </span>
                                <!--end::Name-->

                                <!--begin::Label-->
                                <span class="badge badge-light-primary">Shipping</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Customer-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="border border-dashed border-gray-300 rounded px-7 py-3 mb-6">
                            <!--begin::Info-->
                            <div class="d-flex flex-stack mb-3">
                                <!--begin::Wrapper-->
                                <div class="me-3">
                                    <!--begin::Icon-->
                                    <img src="/metronic8/demo1/assets/media/stock/ecommerce/214.gif"
                                         class="w-50px ms-n1 me-1" alt="">
                                    <!--end::Icon-->

                                    <!--begin::Title-->
                                    <a href="/metronic8/demo1/../demo1/apps/ecommerce/catalog/edit-product.html"
                                       class="text-gray-800 text-hover-primary fw-bold">Yellow Stone</a>
                                    <!--end::Title-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Action-->
                                <div class="m-0">
                                    <!--begin::Menu-->
                                    <button
                                        class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                        data-kt-menu-overflow="true">

                                        <i class="ki-duotone ki-dots-square fs-1"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span></i>
                                    </button>

                                    <!--begin::Menu 2-->
                                    <div
                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Quick Actions
                                            </div>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <div class="separator mb-3 opacity-75"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Ticket
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Customer
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                             data-kt-menu-placement="right-start">
                                            <!--begin::Menu item-->
                                            <a href="#" class="menu-link px-3">
                                                <span class="menu-title">New Group</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <!--end::Menu item-->

                                            <!--begin::Menu sub-->
                                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Admin Group
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Staff Group
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Member Group
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu sub-->
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Contact
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <div class="separator mt-3 opacity-75"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content px-3 py-3">
                                                <a class="btn btn-primary  btn-sm px-4" href="#">
                                                    Generate Reports
                                                </a>
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 2-->

                                    <!--end::Menu-->
                                </div>
                                <!--end::Action-->
                            </div>
                            <!--end::Info-->

                            <!--begin::Customer-->
                            <div class="d-flex flex-stack">
                                <!--begin::Name-->
                                <span class="text-gray-400 fw-bold">To:
                            <a href="/metronic8/demo1/../demo1/apps/ecommerce/sales/details.html"
                               class="text-gray-800 text-hover-primary fw-bold">
                                Dan Wilson                            </a>
                        </span>
                                <!--end::Name-->

                                <!--begin::Label-->
                                <span class="badge badge-light-danger">Confirmed</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Customer-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="border border-dashed border-gray-300 rounded px-7 py-3 mb-6">
                            <!--begin::Info-->
                            <div class="d-flex flex-stack mb-3">
                                <!--begin::Wrapper-->
                                <div class="me-3">
                                    <!--begin::Icon-->
                                    <img src="/metronic8/demo1/assets/media/stock/ecommerce/211.gif"
                                         class="w-50px ms-n1 me-1" alt="">
                                    <!--end::Icon-->

                                    <!--begin::Title-->
                                    <a href="/metronic8/demo1/../demo1/apps/ecommerce/catalog/edit-product.html"
                                       class="text-gray-800 text-hover-primary fw-bold">Elephant 1802</a>
                                    <!--end::Title-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Action-->
                                <div class="m-0">
                                    <!--begin::Menu-->
                                    <button
                                        class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                        data-kt-menu-overflow="true">

                                        <i class="ki-duotone ki-dots-square fs-1"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span></i>
                                    </button>

                                    <!--begin::Menu 2-->
                                    <div
                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Quick Actions
                                            </div>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <div class="separator mb-3 opacity-75"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Ticket
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Customer
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                             data-kt-menu-placement="right-start">
                                            <!--begin::Menu item-->
                                            <a href="#" class="menu-link px-3">
                                                <span class="menu-title">New Group</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <!--end::Menu item-->

                                            <!--begin::Menu sub-->
                                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Admin Group
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Staff Group
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Member Group
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu sub-->
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Contact
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <div class="separator mt-3 opacity-75"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content px-3 py-3">
                                                <a class="btn btn-primary  btn-sm px-4" href="#">
                                                    Generate Reports
                                                </a>
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 2-->

                                    <!--end::Menu-->
                                </div>
                                <!--end::Action-->
                            </div>
                            <!--end::Info-->

                            <!--begin::Customer-->
                            <div class="d-flex flex-stack">
                                <!--begin::Name-->
                                <span class="text-gray-400 fw-bold">To:
                            <a href="/metronic8/demo1/../demo1/apps/ecommerce/sales/details.html"
                               class="text-gray-800 text-hover-primary fw-bold">
                                Lebron Wayde                            </a>
                        </span>
                                <!--end::Name-->

                                <!--begin::Label-->
                                <span class="badge badge-light-success">Delivered</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Customer-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="border border-dashed border-gray-300 rounded px-7 py-3 mb-6">
                            <!--begin::Info-->
                            <div class="d-flex flex-stack mb-3">
                                <!--begin::Wrapper-->
                                <div class="me-3">
                                    <!--begin::Icon-->
                                    <img src="/metronic8/demo1/assets/media/stock/ecommerce/215.gif"
                                         class="w-50px ms-n1 me-1" alt="">
                                    <!--end::Icon-->

                                    <!--begin::Title-->
                                    <a href="/metronic8/demo1/../demo1/apps/ecommerce/catalog/edit-product.html"
                                       class="text-gray-800 text-hover-primary fw-bold">RiseUP</a>
                                    <!--end::Title-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Action-->
                                <div class="m-0">
                                    <!--begin::Menu-->
                                    <button
                                        class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                        data-kt-menu-overflow="true">

                                        <i class="ki-duotone ki-dots-square fs-1"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span></i>
                                    </button>

                                    <!--begin::Menu 2-->
                                    <div
                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Quick Actions
                                            </div>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <div class="separator mb-3 opacity-75"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Ticket
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Customer
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                             data-kt-menu-placement="right-start">
                                            <!--begin::Menu item-->
                                            <a href="#" class="menu-link px-3">
                                                <span class="menu-title">New Group</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <!--end::Menu item-->

                                            <!--begin::Menu sub-->
                                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Admin Group
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Staff Group
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Member Group
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu sub-->
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Contact
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <div class="separator mt-3 opacity-75"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content px-3 py-3">
                                                <a class="btn btn-primary  btn-sm px-4" href="#">
                                                    Generate Reports
                                                </a>
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 2-->

                                    <!--end::Menu-->
                                </div>
                                <!--end::Action-->
                            </div>
                            <!--end::Info-->

                            <!--begin::Customer-->
                            <div class="d-flex flex-stack">
                                <!--begin::Name-->
                                <span class="text-gray-400 fw-bold">To:
                            <a href="/metronic8/demo1/../demo1/apps/ecommerce/sales/details.html"
                               class="text-gray-800 text-hover-primary fw-bold">
                                Ana Simmons                            </a>
                        </span>
                                <!--end::Name-->

                                <!--begin::Label-->
                                <span class="badge badge-light-primary">Shipping</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Customer-->
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="border border-dashed border-gray-300 rounded px-7 py-3 ">
                            <!--begin::Info-->
                            <div class="d-flex flex-stack mb-3">
                                <!--begin::Wrapper-->
                                <div class="me-3">
                                    <!--begin::Icon-->
                                    <img src="/metronic8/demo1/assets/media/stock/ecommerce/192.gif"
                                         class="w-50px ms-n1 me-1" alt="">
                                    <!--end::Icon-->

                                    <!--begin::Title-->
                                    <a href="/metronic8/demo1/../demo1/apps/ecommerce/catalog/edit-product.html"
                                       class="text-gray-800 text-hover-primary fw-bold">Yellow Stone</a>
                                    <!--end::Title-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Action-->
                                <div class="m-0">
                                    <!--begin::Menu-->
                                    <button
                                        class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                        data-kt-menu-overflow="true">

                                        <i class="ki-duotone ki-dots-square fs-1"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span></i>
                                    </button>

                                    <!--begin::Menu 2-->
                                    <div
                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content fs-6 text-dark fw-bold px-3 py-4">Quick Actions
                                            </div>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <div class="separator mb-3 opacity-75"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Ticket
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Customer
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3" data-kt-menu-trigger="hover"
                                             data-kt-menu-placement="right-start">
                                            <!--begin::Menu item-->
                                            <a href="#" class="menu-link px-3">
                                                <span class="menu-title">New Group</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <!--end::Menu item-->

                                            <!--begin::Menu sub-->
                                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Admin Group
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Staff Group
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Member Group
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu sub-->
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Contact
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <div class="separator mt-3 opacity-75"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content px-3 py-3">
                                                <a class="btn btn-primary  btn-sm px-4" href="#">
                                                    Generate Reports
                                                </a>
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 2-->

                                    <!--end::Menu-->
                                </div>
                                <!--end::Action-->
                            </div>
                            <!--end::Info-->

                            <!--begin::Customer-->
                            <div class="d-flex flex-stack">
                                <!--begin::Name-->
                                <span class="text-gray-400 fw-bold">To:
                            <a href="/metronic8/demo1/../demo1/apps/ecommerce/sales/details.html"
                               class="text-gray-800 text-hover-primary fw-bold">
                                Kevin Leonard                            </a>
                        </span>
                                <!--end::Name-->

                                <!--begin::Label-->
                                <span class="badge badge-light-danger">Confirmed</span>
                                <!--end::Label-->
                            </div>
                            <!--end::Customer-->
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::List widget 5-->


        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-xl-8">

            <!--begin::Package Sells Chart -->
            <div class="card card-flush overflow-hidden h-md-100">
                <!--begin::Header-->
                <div class="card-header py-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">درآمد سالیانه</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">مقدار فروش هر ماه</span>
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->

                <!--begin::Card body-->
                <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
                    <!--begin::Info-->
                    <div class="px-9 mb-5">
                        <!--begin::Statistics-->
                        <div class="d-flex align-items-center mb-2">

                            <!--begin::Value-->
                            <span
                                class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{convertNumbers(number_format($totalYearIncome))}}</span>
                            <!--end::Value-->

                            <!--begin::Currency-->
                            <span class="fs-4 fw-semibold text-gray-400 align-self-start me-1">تومان</span>
                            <!--end::Currency-->
                        </div>
                        <!--end::Statistics-->

                        <!--begin::Description-->
                        <span class="fs-6 fw-semibold text-gray-400">مقدار فروش ۱۲ ماه گذشته</span>
                        <!--end::Description-->
                    </div>
                    <!--end::Info-->

                    <!--begin::Chart-->
                    <div id="annually_income_chart" class="min-h-auto ps-4 pe-6"
                         style="height: 300px; min-height: 315px;"></div>
                    <!--end::Chart-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Package Sells Chart-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->         </div>

@push('scripts')
    <script>
        /////////////////////////////////////////////////////////////
        var element = document.getElementById('package_sells_chart');

        var height = parseInt(KTUtil.css(element, 'height'));
        var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
        var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');
        var baseColor = KTUtil.getCssVariableValue('--kt-primary');
        var secondaryColor = KTUtil.getCssVariableValue('--kt-gray-300');


        var options = {
            series: [{
                name: 'تعداد اشتراک خریداری شده',
                data: {{json_encode($plansSell)}}
            }],
            tooltip: {
                enabled: false,
            },
            chart: {
                fontFamily: 'inherit',
                type: 'bar',
                height: height,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: ['30%'],
                    endingShape: 'rounded'
                },
            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: {!! json_encode($plansName, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)!!},
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '12px'
                    }
                }
            },
            fill: {
                opacity: 1
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            colors: [baseColor, secondaryColor],
            grid: {
                borderColor: borderColor,
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            }
        };

        var chart = new ApexCharts(element, options);
        chart.render();
        ///////////////////////////////////////////////////////////////

        var element = document.getElementById('annually_income_chart');

        var height = parseInt(KTUtil.css(element, 'height'));
        var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
        var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');
        var baseColor = KTUtil.getCssVariableValue('--kt-primary');
        var secondaryColor = KTUtil.getCssVariableValue('--kt-gray-300');


        var options = {
            series: [{
                name: 'درآمد ماهیانه',
                data: {{json_encode($annualSells)}}
            }],
            tooltip: {
                enabled: false,
            },
            chart: {
                fontFamily: 'inherit',
                type: 'bar',
                height: height,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: ['30%'],
                    endingShape: 'rounded'
                },
            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: {!! json_encode($annualNames, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)!!},
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '12px'
                    }
                }
            },
            fill: {
                opacity: 1
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            colors: [baseColor, secondaryColor],
            grid: {
                borderColor: borderColor,
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            }
        };

        var chart = new ApexCharts(element, options);
        chart.render();
        ////////////////////////////////////////////////////////////////
        var element = document.getElementById('month_sales_chart');

        var height = parseInt(KTUtil.css(element, 'height'));
        var width = parseInt(KTUtil.css(element, 'width'));
        var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
        var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');
        var baseColor = KTUtil.getCssVariableValue('--kt-success');
        var lightColor = KTUtil.getCssVariableValue('--kt-success-light');


        var options = {
            series: [{
                name: 'فروش روزانه',
                data: {!! json_encode($currentMonthSells, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)!!}
            }],
            chart: {
                fontFamily: 'inherit',
                type: 'area',
                height: height,
                width: width,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {},
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            fill: {
                type: 'solid',
                opacity: 1
            },
            stroke: {
                curve: 'smooth',
                show: true,
                width: 3,
                colors: [baseColor]
            },
            xaxis: {
                categories: {!! json_encode($currentMonthDays, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)!!},
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '12px'
                    }
                },
                crosshairs: {
                    position: 'front',
                    stroke: {
                        color: baseColor,
                        width: 1,
                        dashArray: 3
                    }
                },
                tooltip: {
                    enabled: true,
                    formatter: undefined,
                    offsetY: 0,
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '12px'
                    }
                }
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: '12px'
                },
                y: {
                    formatter: function (val) {
                        return val.toLocaleString() + " تومان"
                    }
                }
            },
            colors: [lightColor],
            grid: {
                borderColor: borderColor,
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            markers: {
                strokeColor: baseColor,
                strokeWidth: 3
            }
        };

        var chart = new ApexCharts(element, options);
        chart.render();
    </script>
@endpush
@section('title')
    پیشخان
@endsection
@section('description')
    پیشخان پنل مدیریت
@endsection
