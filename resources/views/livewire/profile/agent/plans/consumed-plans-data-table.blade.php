<div class="card pt-4 mt-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>طرح های مصرف شده</h2>
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Button-->
            {{--                                            <button type="button" class="btn btn-sm btn-light-primary">--}}
            {{--                                                <!--begin::Svg Icon | path: -->--}}
            {{--                                            <?= get_svg_icon('icons/duotone/Files/Download.svg')?>--}}
            {{--                                            <!--end::Svg Icon-->Download Report</button>--}}
            <!--end::Button-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body py-0 border-top">
            <!--begin::Table wrapper-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table  class="table align-middle table-row-dashed fs-6 gy-5" id="agent-plans-table"><thead><tr><th  title="ردیف">ردیف</th><th  title="نام طرح">نام طرح</th><th  title="قیمت">قیمت</th><th  title="تعداد کاربر">تعداد کاربر</th><th  title="مدت طرح">مدت طرح</th><th  title="تاریخ خرید">تاریخ خرید</th><th  title="تاریخ اتمام طرح">تاریخ اتمام طرح</th><th  title="عملیات">عملیات</th></tr></thead></table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Card body-->
    </div>
@push('scripts')
<script type="text/javascript">$(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["agent-plans-table"]=$("#agent-plans-table").DataTable({"serverSide":true,"processing":true,"ajax":{"url":"{{route('agents.getPlans',$user)}}","type":"GET","data":function(data) {
                for (var i = 0, len = data.columns.length; i < len; i++) {
                    if (!data.columns[i].search.value) delete data.columns[i].search;
                    if (data.columns[i].searchable === true) delete data.columns[i].searchable;
                    if (data.columns[i].orderable === true) delete data.columns[i].orderable;
                    if (data.columns[i].data === data.columns[i].name) delete data.columns[i].name;
                }
                delete data.search.regex;}},"columns":[{"data":"DT_RowIndex","name":"DT_RowIndex","title":"\u0631\u062f\u06cc\u0641","orderable":true,"searchable":true},{"data":"plan_title","name":"plan_title","title":"\u0646\u0627\u0645 \u0637\u0631\u062d","orderable":true,"searchable":true},{"data":"plan_price","name":"plan_price","title":"\u0642\u06cc\u0645\u062a","orderable":true,"searchable":true},{"data":"plan_users_count","name":"plan_users_count","title":"\u062a\u0639\u062f\u0627\u062f \u06a9\u0627\u0631\u0628\u0631","orderable":true,"searchable":true},{"data":"plan_duration","name":"plan_duration","title":"\u0645\u062f\u062a \u0637\u0631\u062d","orderable":true,"searchable":true},{"data":"bought_at","name":"bought_at","title":"\u062a\u0627\u0631\u06cc\u062e \u062e\u0631\u06cc\u062f","orderable":true,"searchable":true},{"data":"consumed_at","name":"consumed_at","title":"\u062a\u0627\u0631\u06cc\u062e \u0627\u062a\u0645\u0627\u0645 \u0637\u0631\u062d","orderable":true,"searchable":true},{"data":"action","name":"action","title":"\u0639\u0645\u0644\u06cc\u0627\u062a","orderable":true,"searchable":true}],"language":{"url":"{{asset('js/Persian.json')}}"},"stateSave":true,"order":[[0,"desc"]],"responsive":true,"autoWidth":true,"scrollX":false});

        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        LaravelDataTables["agent-plans-table"].on('click', '[data-destroy]', function (e) {
            e.preventDefault();
            if (!confirm("Are you sure to delete this record?")) {
                return;
            }
            axios.delete($(this).data('destroy'), {
                '_method': 'DELETE',
            })
                .then(function (response) {
                    LaravelDataTables["agent-plans-table"].ajax.reload();
                })
                .catch(function (error) {
                    console.log(error);
                });
        });

    });
    </script>
@endpush
