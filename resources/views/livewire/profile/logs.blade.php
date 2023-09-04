<div>
    <!-- begin::Logs DataTable -->
    <div class="card pt-4 mt-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>گزارش</h2>
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
                <table  class="table align-middle table-row-dashed fs-6 gy-5" id="activity-log-table"><thead><tr><th  title="ردیف">ردیف</th><th  title="نام لاگ">نام لاگ</th><th  title="رویداد">رویداد</th><th  title="توضیحات">توضیحات</th><th  title="تاثیر پذیر">تاثیر پذیر</th><th  title="تاثیر گذار">تاثیر گذار</th><th  title="تاریخ ثبت">تاریخ ثبت</th><th  title="سایر">سایر</th></tr></thead></table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end:::Logs DataTable -->
</div>
@push('styles')
    <link rel="preload" href="{{asset('plugins/custom/datatables/datatables.bundle.rtl.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'" type="text/css"><noscript><link rel="stylesheet" href="{{asset('plugins/custom/datatables/datatables.bundle.rtl.css')}}"></noscript>
@endpush

@push('scripts')
    <script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script type="text/javascript">
        $(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["activity-log-table"]=$("#activity-log-table").DataTable({"serverSide":true,"processing":true,"ajax":{"url":"{{route('users.logs',$user)}}","type":"GET","data":function(data) {
                    for (var i = 0, len = data.columns.length; i < len; i++) {
                        if (!data.columns[i].search.value) delete data.columns[i].search;
                        if (data.columns[i].searchable === true) delete data.columns[i].searchable;
                        if (data.columns[i].orderable === true) delete data.columns[i].orderable;
                        if (data.columns[i].data === data.columns[i].name) delete data.columns[i].name;
                    }
                    delete data.search.regex;}},"columns":[{"data":"id","name":"id","title":"\u0631\u062f\u06cc\u0641","orderable":true,"searchable":true},{"data":"log_name","name":"log_name","title":"\u0646\u0627\u0645 \u0644\u0627\u06af","orderable":true,"searchable":true},{"data":"event","name":"event","title":"\u0631\u0648\u06cc\u062f\u0627\u062f","orderable":true,"searchable":true},{"data":"description","name":"description","title":"\u062a\u0648\u0636\u06cc\u062d\u0627\u062a","orderable":true,"searchable":true,"className":"none"},{"data":"subject_id","name":"subject_id","title":"\u062a\u0627\u062b\u06cc\u0631 \u067e\u0630\u06cc\u0631","orderable":true,"searchable":true,"className":"none"},{"data":"causer_id","name":"causer_id","title":"\u062a\u0627\u062b\u06cc\u0631 \u06af\u0630\u0627\u0631","orderable":true,"searchable":true},{"data":"created_at","name":"created_at","title":"\u062a\u0627\u0631\u06cc\u062e \u062b\u0628\u062a","orderable":true,"searchable":true},{"data":"properties","name":"properties","title":"\u0633\u0627\u06cc\u0631","orderable":true,"searchable":true,"className":"none"}],"language":{"url":"{{asset('js/Persian.json')}}"},"stateSave":true,"order":[[1,"desc"]],"responsive":true,"autoWidth":true,"scrollX":false});

            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            LaravelDataTables["activity-log-table"].on('click', '[data-destroy]', function (e) {
                e.preventDefault();
                if (!confirm("Are you sure to delete this record?")) {
                    return;
                }
                axios.delete($(this).data('destroy'), {
                    '_method': 'DELETE',
                })
                    .then(function (response) {
                        LaravelDataTables["activity-log-table"].ajax.reload();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            });

        });
    </script>
@endpush
