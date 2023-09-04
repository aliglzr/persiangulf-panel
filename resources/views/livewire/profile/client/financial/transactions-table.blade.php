<div>
    <!-- begin::Logs DataTable -->
    <div class="card pt-4 mt-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>تراکنش ها</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body py-0 border-top">
            <!--begin::Table wrapper-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table  class="table align-middle table-row-dashed fs-6 gy-5" id="transactions-table"><thead><tr><th  title="شناسه">شناسه</th><th  title="مبلغ">مبلغ</th><th  title="موجودی قبل از تراکنش">موجودی قبل از تراکنش</th><th  title="موجودی بعد از تراکنش">موجودی بعد از تراکنش</th><th  title="توضیحات">توضیحات</th><th  title="تاریخ">تاریخ</th></tr></thead></table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end:::Logs DataTable -->
</div>


@push('scripts')

    <script type="text/javascript">$(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["transactions-table"]=$("#transactions-table").DataTable({"serverSide":true,"processing":true,"ajax":{"url":"{{route('clients.transactions',$user)}}","type":"GET","data":function(data) {
                    for (var i = 0, len = data.columns.length; i < len; i++) {
                        if (!data.columns[i].search.value) delete data.columns[i].search;
                        if (data.columns[i].searchable === true) delete data.columns[i].searchable;
                        if (data.columns[i].orderable === true) delete data.columns[i].orderable;
                        if (data.columns[i].data === data.columns[i].name) delete data.columns[i].name;
                    }
                    delete data.search.regex;}},"columns":[{"data":"id","name":"id","title":"\u0634\u0646\u0627\u0633\u0647","orderable":true,"searchable":true},{"data":"amount","name":"amount","title":"\u0645\u0628\u0644\u063a","orderable":true,"searchable":true},{"data":"balance_before_transaction","name":"balance_before_transaction","title":"\u0645\u0648\u062c\u0648\u062f\u06cc \u0642\u0628\u0644 \u0627\u0632 \u062a\u0631\u0627\u06a9\u0646\u0634","orderable":true,"searchable":true},{"data":"balance_after_transaction","name":"balance_after_transaction","title":"\u0645\u0648\u062c\u0648\u062f\u06cc \u0628\u0639\u062f \u0627\u0632 \u062a\u0631\u0627\u06a9\u0646\u0634","orderable":true,"searchable":true},{"data":"description","name":"description","title":"\u062a\u0648\u0636\u06cc\u062d\u0627\u062a","orderable":true,"searchable":true},{"data":"updated_at","name":"updated_at","title":"\u062a\u0627\u0631\u06cc\u062e","orderable":true,"searchable":true}],"language":{"url":"{{asset('js/Persian.json')}}"},"stateSave":true,"order":[[0,"desc"]],"responsive":true,"autoWidth":false,"scrollX":true});

            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            LaravelDataTables["transactions-table"].on('click', '[data-destroy]', function (e) {
                e.preventDefault();
                if (!confirm("Are you sure to delete this record?")) {
                    return;
                }
                axios.delete($(this).data('destroy'), {
                    '_method': 'DELETE',
                })
                    .then(function (response) {
                        LaravelDataTables["transactions-table"].ajax.reload();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            });

        });
    </script>

@endpush
