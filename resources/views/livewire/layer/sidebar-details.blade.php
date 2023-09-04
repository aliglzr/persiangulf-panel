<div class="pb-5 fs-6">
    <div>
        @if($layer->servers()->where('active',false)->count())
            <!--begin::Details item-->
            <div class="fw-bold mt-5">سرور غیر فعال</div>
            <div class="text-gray-600"><span
                        class="badge badge-light-warning">{{convertNumbers($layer->servers()->where('active',false)->count())}}</span>
            </div>
            <!--begin::Details item-->
        @endif
        <!--begin::Details item-->
        <div class="fw-bold mt-5">تنوع کشور</div>
        <div class="text-gray-600"><span
                    class="badge badge-light-success">{{convertNumbers(count(array_unique($layer->servers()->pluck('country_id')->toArray())))}}</span>
        </div>
        <!--begin::Details item-->
        <!--begin::Details item-->
        <div class="fw-bold mt-5">حداکثر تعداد مشتری</div>
        <div class="text-gray-600"><span
                    class="badge badge-light-success">{{convertNumbers($layer->max_client)}}</span>
        </div>
        <!--begin::Details item-->
        <!--begin::Details item-->
        <div class="fw-bold mt-5">نسبت ایجاد مشتری</div>
        <div class="text-dark"><span class="badge badge-light-info">{{convertNumbers($layer->load)}}</span></div>
        <!--begin::Details item-->
        <!--begin::Details item-->
        <div class="fw-bold mt-5">اخرین بروزرسانی</div>
        <div class="text-gray-600">{{\App\Core\Extensions\Verta\Verta::instance($layer?->updated_at)->persianFormat('Y/m/d H:i:s')}}</div>
        <!--begin::Details item-->
        <!--begin::Details item-->
        <div class="fw-bold mt-5">تاریخ ایجاد</div>
        <div class="text-gray-600">{{\App\Core\Extensions\Verta\Verta::instance($layer?->updated_at)->persianFormat('Y/m/d H:i:s')}}</div>
        <!--begin::Details item-->
    </div>
</div>
