<div>
    <!-- begin::Logs DataTable -->
    <div class="card pt-4 mt-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>اشتراک های پایان یافته</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body py-0 border-top">
            <!--begin::Table wrapper-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table  class="table align-middle table-row-dashed fs-6 gy-5" id="subscriptions-table"><thead><tr><th  title="ردیف">ردیف</th><th  title="نام اشتراک">نام اشتراک</th><th  title="محدودیت حجم">محدودیت حجم</th><th  title="مدت اشتراک">مدت اشتراک</th><th  title="زمان شروع">زمان شروع</th><th  title="زمان اتمام">زمان اتمام</th><th  title="عملیات">عملیات</th></tr></thead></table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end:::Logs DataTable -->
</div>

@push('styles')
    <link rel="stylesheet" href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}">
@endpush
@push('scripts')
    <script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script type="text/javascript">
        $(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["subscriptions-table"]=$("#subscriptions-table").DataTable({"serverSide":true,"processing":true,"ajax":{"url":"{{route('clients.getSubscriptions',$user)}}","type":"GET","data":function(data) {
                    for (var i = 0, len = data.columns.length; i < len; i++) {
                        if (!data.columns[i].search.value) delete data.columns[i].search;
                        if (data.columns[i].searchable === true) delete data.columns[i].searchable;
                        if (data.columns[i].orderable === true) delete data.columns[i].orderable;
                        if (data.columns[i].data === data.columns[i].name) delete data.columns[i].name;
                    }
                    delete data.search.regex;}},"columns":[{"data":"DT_RowIndex","name":"DT_RowIndex","title":"\u0631\u062f\u06cc\u0641","orderable":true,"searchable":true},{"data":"title","name":"title","title":"\u0646\u0627\u0645 \u0627\u0634\u062a\u0631\u0627\u06a9","orderable":true,"searchable":true},{"data":"traffic","name":"traffic","title":"\u0645\u062d\u062f\u0648\u062f\u06cc\u062a \u062d\u062c\u0645","orderable":true,"searchable":true},{"data":"duration","name":"duration","title":"\u0645\u062f\u062a \u0627\u0634\u062a\u0631\u0627\u06a9","orderable":true,"searchable":true},{"data":"starts_at","name":"starts_at","title":"\u0632\u0645\u0627\u0646 \u0634\u0631\u0648\u0639","orderable":true,"searchable":true},{"data":"ends_at","name":"ends_at","title":"\u0632\u0645\u0627\u0646 \u0627\u062a\u0645\u0627\u0645","orderable":true,"searchable":true},{"data":"actions","name":"actions","title":"\u0639\u0645\u0644\u06cc\u0627\u062a","orderable":false,"searchable":false}],"language":{"url":"{{asset('js/Persian.json')}}"},"stateSave":true,"order":[[0,"desc"]],"responsive":true,"autoWidth":true,"scrollX":false});

            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            LaravelDataTables["subscriptions-table"].on('click', '[data-destroy]', function (e) {
                e.preventDefault();
                if (!confirm("Are you sure to delete this record?")) {
                    return;
                }
                axios.delete($(this).data('destroy'), {
                    '_method': 'DELETE',
                })
                    .then(function (response) {
                        LaravelDataTables["subscriptions-table"].ajax.reload();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            });

        });
    </script>

@endpush
