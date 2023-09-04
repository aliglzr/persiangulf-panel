<div wire:ignore class="card card-flush mb-6 mb-xl-9">
    <!--begin::Card header-->
    <div class="card-header">
        <!--begin::Card title-->
        <div class="card-title flex-column">
            <h2 class="mb-1">لیست سرور ها</h2>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0">
        <!--begin::Table-->
        <table  class="table align-middle table-row-dashed fs-6 gy-5" id="servers-table"><thead><tr><th  title="شناسه">شناسه</th><th  title="نام">نام</th><th  title="آدرس آیپی">آدرس آیپی</th><th  title="توضیحات">توضیحات</th><th  title="شهر">شهر</th><th  title="کشور">کشور</th><th  title="لایه">لایه</th><th  title="وضعیت">وضعیت</th><th  title="آخرین بروزرسانی">آخرین بروزرسانی</th><th  title="عملیات">عملیات</th><th  title="دارای v2ray">دارای v2ray</th><th  title="آدرس فایل کلید خصوصی">آدرس فایل کلید خصوصی</th><th  title="آدرس فایل کلید عمومی">آدرس فایل کلید عمومی</th></tr></thead></table>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>
@push('scripts')
    <script>
        $(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["servers-table"]=$("#servers-table").DataTable({"serverSide":true,"processing":true,"ajax":{"url":"{{route('layers.servers',$layer)}}","type":"GET","data":function(data) {
                    for (var i = 0, len = data.columns.length; i < len; i++) {
                        if (!data.columns[i].search.value) delete data.columns[i].search;
                        if (data.columns[i].searchable === true) delete data.columns[i].searchable;
                        if (data.columns[i].orderable === true) delete data.columns[i].orderable;
                        if (data.columns[i].data === data.columns[i].name) delete data.columns[i].name;
                    }
                    delete data.search.regex;}},"columns":[{"data":"id","name":"id","title":"\u0634\u0646\u0627\u0633\u0647","orderable":true,"searchable":true},{"data":"name","name":"name","title":"\u0646\u0627\u0645","orderable":true,"searchable":true},{"data":"ip_address","name":"ip_address","title":"\u0622\u062f\u0631\u0633 \u0622\u06cc\u067e\u06cc","orderable":true,"searchable":true},{"data":"description","name":"description","title":"\u062a\u0648\u0636\u06cc\u062d\u0627\u062a","orderable":true,"searchable":true,"className":"d-none"},{"data":"city","name":"city","title":"\u0634\u0647\u0631","orderable":true,"searchable":true},{"data":"country_id","name":"country_id","title":"\u06a9\u0634\u0648\u0631","orderable":true,"searchable":true},{"data":"layer_id","name":"layer_id","title":"\u0644\u0627\u06cc\u0647","orderable":true,"searchable":true},{"data":"active","name":"active","title":"\u0648\u0636\u0639\u06cc\u062a","orderable":true,"searchable":true},{"data":"updated_at","name":"updated_at","title":"\u0622\u062e\u0631\u06cc\u0646 \u0628\u0631\u0648\u0632\u0631\u0633\u0627\u0646\u06cc","orderable":true,"searchable":true},{"data":"actions","name":"actions","title":"\u0639\u0645\u0644\u06cc\u0627\u062a","orderable":false,"searchable":false},{"data":"private_key","name":"private_key","title":"\u0622\u062f\u0631\u0633 \u0641\u0627\u06cc\u0644 \u06a9\u0644\u06cc\u062f \u062e\u0635\u0648\u0635\u06cc","orderable":true,"searchable":true,"className":"none"},{"data":"public_key","name":"public_key","title":"\u0622\u062f\u0631\u0633 \u0641\u0627\u06cc\u0644 \u06a9\u0644\u06cc\u062f \u0639\u0645\u0648\u0645\u06cc","orderable":true,"searchable":true,"className":"none"}],"language":{"url":"{{asset('js/Persian.json')}}"},"stateSave":true,"order":[[0,"desc"]],"responsive":true,"autoWidth":false,"scrollX":true});

            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            LaravelDataTables["servers-table"].on('click', '[data-destroy]', function (e) {
                e.preventDefault();
                if (!confirm("Are you sure to delete this record?")) {
                    return;
                }
                axios.delete($(this).data('destroy'), {
                    '_method': 'DELETE',
                })
                    .then(function (response) {
                        LaravelDataTables["servers-table"].ajax.reload();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            });
        });
    </script>
@endpush
