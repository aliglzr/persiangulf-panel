<div>
    <!-- begin::Logs DataTable -->
    <div class="card pt-4 mt-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>پرداخت ها</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body py-0 border-top">
            <!--begin::Table wrapper-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table  class="table align-middle table-row-dashed fs-6 gy-5" id="payments-table"><thead><tr><th  title="شناسه">شناسه</th><th  title="مبلغ">مبلغ</th><th  title="وضعیت">وضعیت</th><th  title="شماره پیگیری">شماره پیگیری</th><th  title="تاریخ">تاریخ</th></tr></thead></table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end:::Logs DataTable -->
</div>


@push('scripts')

    <script type="text/javascript">
        $(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["payments-table"]=$("#payments-table").DataTable({"serverSide":true,"processing":true,"ajax":{"url":"{{route('clients.payments',$user)}}","type":"GET","data":function(data) {
                    for (var i = 0, len = data.columns.length; i < len; i++) {
                        if (!data.columns[i].search.value) delete data.columns[i].search;
                        if (data.columns[i].searchable === true) delete data.columns[i].searchable;
                        if (data.columns[i].orderable === true) delete data.columns[i].orderable;
                        if (data.columns[i].data === data.columns[i].name) delete data.columns[i].name;
                    }
                    delete data.search.regex;}},"columns":[{"data":"id","name":"id","title":"\u0634\u0646\u0627\u0633\u0647","orderable":true,"searchable":true},{"data":"amount","name":"amount","title":"\u0645\u0628\u0644\u063a","orderable":true,"searchable":true},{"data":"status","name":"status","title":"\u0648\u0636\u0639\u06cc\u062a","orderable":true,"searchable":true},{"data":"reference_id","name":"reference_id","title":"\u0634\u0645\u0627\u0631\u0647 \u067e\u06cc\u06af\u06cc\u0631\u06cc","orderable":true,"searchable":true},{"data":"updated_at","name":"updated_at","title":"\u062a\u0627\u0631\u06cc\u062e","orderable":true,"searchable":true}],"language":{"url":"{{asset('js/Persian.json')}}"},"stateSave":true,"order":[[0,"desc"]],"responsive":true,"autoWidth":false,"scrollX":true});

            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            LaravelDataTables["payments-table"].on('click', '[data-destroy]', function (e) {
                e.preventDefault();
                if (!confirm("Are you sure to delete this record?")) {
                    return;
                }
                axios.delete($(this).data('destroy'), {
                    '_method': 'DELETE',
                })
                    .then(function (response) {
                        LaravelDataTables["payments-table"].ajax.reload();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            });

        });
    </script>

@endpush
