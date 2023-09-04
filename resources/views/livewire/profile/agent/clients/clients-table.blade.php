<div>
    <!-- begin::Agent Clients DataTable -->
    <div class="card pt-4 mt-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>لیست مشتریان</h2>
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
                <table  class="table align-middle table-row-dashed fs-6 gy-5" id="clients-table"><thead><tr><th  title="شناسه">شناسه</th><th  title="نام مشتری">نام مشتری</th><th  title="نام کاربری">نام کاربری</th><th  title="معرف">معرف</th><th  title="اعتبار">اعتبار</th><th  title="شروع اعتبار">شروع اعتبار</th><th  title="پایان اعتبار">پایان اعتبار</th><th  title="تاریخ ثبت مشتری">تاریخ ثبت مشتری</th><th  title="عملیات">عملیات</th></tr></thead></table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end:::Agent Clients DataTable -->
    <livewire:profile.agent.plans.renew-subscription />
    <livewire:layer.change-layer-modal />
</div>


@push('scripts')

    <script type="text/javascript">$(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["clients-table"]=$("#clients-table").DataTable({"serverSide":true,"processing":true,"ajax":{"url":"{{route('agents.getClients',$user)}}","type":"GET","data":function(data) {
                    for (var i = 0, len = data.columns.length; i < len; i++) {
                        if (!data.columns[i].search.value) delete data.columns[i].search;
                        if (data.columns[i].searchable === true) delete data.columns[i].searchable;
                        if (data.columns[i].orderable === true) delete data.columns[i].orderable;
                        if (data.columns[i].data === data.columns[i].name) delete data.columns[i].name;
                    }
                    delete data.search.regex;}},"columns":[{"data":"id","name":"id","title":"\u0634\u0646\u0627\u0633\u0647","orderable":true,"searchable":true},{"data":"full_name","name":"full_name","title":"\u0646\u0627\u0645 \u0645\u0634\u062a\u0631\u06cc","orderable":true,"searchable":true},{"data":"username","name":"username","title":"\u0646\u0627\u0645 \u06a9\u0627\u0631\u0628\u0631\u06cc","orderable":true,"searchable":true},{"data":"introducer","name":"introducer","title":"\u0645\u0639\u0631\u0641","orderable":true,"searchable":true},{"data":"balance","name":"balance","title":"\u0627\u0639\u062a\u0628\u0627\u0631","orderable":true,"searchable":true},{"data":"starts_at","name":"starts_at","title":"\u0634\u0631\u0648\u0639 \u0627\u0639\u062a\u0628\u0627\u0631","orderable":true,"searchable":true},{"data":"ends_at","name":"ends_at","title":"\u067e\u0627\u06cc\u0627\u0646 \u0627\u0639\u062a\u0628\u0627\u0631","orderable":true,"searchable":true},{"data":"created_at","name":"created_at","title":"\u062a\u0627\u0631\u06cc\u062e \u062b\u0628\u062a \u0645\u0634\u062a\u0631\u06cc","orderable":true,"searchable":true},{"data":"action","name":"action","title":"\u0639\u0645\u0644\u06cc\u0627\u062a","orderable":false,"searchable":false}],"language":{"url":"{{asset('js/Persian.json')}}"},"stateSave":true,"order":[[1,"desc"]],"responsive":true,"autoWidth":true,"scrollX":false});

            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            LaravelDataTables["clients-table"].on('click', '[data-destroy]', function (e) {
                e.preventDefault();
                if (!confirm("Are you sure to delete this record?")) {
                    return;
                }
                axios.delete($(this).data('destroy'), {
                    '_method': 'DELETE',
                })
                    .then(function (response) {
                        LaravelDataTables["clients-table"].ajax.reload();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            });
        });
    </script>

@endpush
