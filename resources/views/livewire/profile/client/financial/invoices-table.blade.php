<div>
    <!-- begin::Logs DataTable -->
    <div class="card pt-4 mt-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>صورتحساب ها</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body py-0 border-top">
            <!--begin::Table wrapper-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table  class="table align-middle table-row-dashed fs-6 gy-5" id="invoices-table"><thead><tr><th  title="شناسه">شناسه</th><th  title="مبلغ کل">مبلغ کل</th><th  title="مبلغ پرداخت شده">مبلغ پرداخت شده</th><th  title="تاریخ ثبت">تاریخ ثبت</th><th  title="عملیات">عملیات</th></tr></thead></table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end:::Logs DataTable -->
</div>


@push('scripts')

    <script type="text/javascript">$(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["invoices-table"]=$("#invoices-table").DataTable({"serverSide":true,"processing":true,"ajax":{"url":"{{route('clients.invoices',$user)}}","type":"GET","data":function(data) {
                    for (var i = 0, len = data.columns.length; i < len; i++) {
                        if (!data.columns[i].search.value) delete data.columns[i].search;
                        if (data.columns[i].searchable === true) delete data.columns[i].searchable;
                        if (data.columns[i].orderable === true) delete data.columns[i].orderable;
                        if (data.columns[i].data === data.columns[i].name) delete data.columns[i].name;
                    }
                    delete data.search.regex;}},"columns":[{"data":"id","name":"id","title":"\u0634\u0646\u0627\u0633\u0647","orderable":true,"searchable":true},{"data":"total_amount","name":"total_amount","title":"\u0645\u0628\u0644\u063a \u06a9\u0644","orderable":true,"searchable":true},{"data":"net_amount_payable","name":"net_amount_payable","title":"\u0645\u0628\u0644\u063a \u067e\u0631\u062f\u0627\u062e\u062a \u0634\u062f\u0647","orderable":true,"searchable":true},{"data":"created_at","name":"created_at","title":"\u062a\u0627\u0631\u06cc\u062e \u062b\u0628\u062a","orderable":true,"searchable":true},{"data":"action","name":"action","title":"\u0639\u0645\u0644\u06cc\u0627\u062a","orderable":false,"searchable":false}],"language":{"url":"{{asset('js/Persian.json')}}"},"stateSave":true,"order":[[0,"desc"]],"responsive":true,"autoWidth":false,"scrollX":true});

            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            LaravelDataTables["invoices-table"].on('click', '[data-destroy]', function (e) {
                e.preventDefault();
                if (!confirm("Are you sure to delete this record?")) {
                    return;
                }
                axios.delete($(this).data('destroy'), {
                    '_method': 'DELETE',
                })
                    .then(function (response) {
                        LaravelDataTables["invoices-table"].ajax.reload();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            });

        });
    </script>

@endpush
