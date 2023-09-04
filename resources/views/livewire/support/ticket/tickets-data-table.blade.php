<div>
    <!-- begin::Tickets DataTable -->
    <div class="card pt-4 mt-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>لیست تیکت ها</h2>
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
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="tickets-table">
                    <thead>
                    <tr>
                        <th title="شماره تیکت">شماره تیکت</th>
                        <th title="عنوان تیکت">عنوان تیکت</th>
                        <th title="وضعیت">وضعیت</th>
                        <th title="اولویت">اولویت</th>
                        <th title="واحد">واحد</th>@role(['support','manager'])
                        <th title="کاربر">کاربر</th>@endrole
                        <th title="کاربر پاسخگو">کاربر پاسخگو</th>
                        <th title="آخرین بروزرسانی">آخرین بروزرسانی</th>
                        <th title="تاریخ ثبت">تاریخ ثبت</th>
                        <th title="امتیاز">امتیاز</th>@role(['support','manager'])
                        <th title=" "></th> @endrole</tr>
                    </thead>
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end:::Logs DataTable -->

    @role(['support','manager'])
    <livewire:support.ticket.actions.lock-ticket/>
    <livewire:support.ticket.actions.resolve-ticket/>
    @endrole
</div>


@push('scripts')

    <script type="text/javascript">$(function () {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables["tickets-table"] = $("#tickets-table").DataTable({
                "serverSide": true,
                "processing": true,
                "ajax": {
                    "url": "{{route('agents.getTickets',$user)}}", "type": "GET", "data": function (data) {
                        for (var i = 0, len = data.columns.length; i < len; i++) {
                            if (!data.columns[i].search.value) delete data.columns[i].search;
                            if (data.columns[i].searchable === true) delete data.columns[i].searchable;
                            if (data.columns[i].orderable === true) delete data.columns[i].orderable;
                            if (data.columns[i].data === data.columns[i].name) delete data.columns[i].name;
                        }
                        delete data.search.regex;
                    }
                },
                "columns": [{
                    "data": "ticket_id",
                    "name": "ticket_id",
                    "title": "\u0634\u0645\u0627\u0631\u0647 \u062a\u06cc\u06a9\u062a",
                    "orderable": true,
                    "searchable": true
                }, {
                    "data": "title",
                    "name": "title",
                    "title": "\u0639\u0646\u0648\u0627\u0646 \u062a\u06cc\u06a9\u062a",
                    "orderable": true,
                    "searchable": true
                }, {
                    "data": "status",
                    "name": "status",
                    "title": "\u0648\u0636\u0639\u06cc\u062a",
                    "orderable": true,
                    "searchable": true
                }, {
                    "data": "priority",
                    "name": "priority",
                    "title": "\u0627\u0648\u0644\u0648\u06cc\u062a",
                    "orderable": true,
                    "searchable": true
                }, {
                    "data": "category_id",
                    "name": "category_id",
                    "title": "\u0648\u0627\u062d\u062f",
                    "orderable": true,
                    "searchable": true
                }, @role(['support','manager']){
                    "data": "user_id",
                    "name": "user_id",
                    "title": "\u06a9\u0627\u0631\u0628\u0631",
                    "orderable": true,
                    "searchable": true
                }, @endrole{
                    "data": "assigned_to_user_id",
                    "name": "assigned_to_user_id",
                    "title": "\u06a9\u0627\u0631\u0628\u0631 \u067e\u0627\u0633\u062e\u06af\u0648",
                    "orderable": true,
                    "searchable": true
                }, {
                    "data": "updated_at",
                    "name": "updated_at",
                    "title": "\u0622\u062e\u0631\u06cc\u0646 \u0628\u0631\u0648\u0632\u0631\u0633\u0627\u0646\u06cc",
                    "orderable": true,
                    "searchable": true
                }, {
                    "data": "created_at",
                    "name": "created_at",
                    "title": "\u062a\u0627\u0631\u06cc\u062e \u062b\u0628\u062a",
                    "orderable": true,
                    "searchable": true
                }, {
                    "data": "rating",
                    "name": "rating",
                    "title": "\u0627\u0645\u062a\u06cc\u0627\u0632",
                    "orderable": true,
                    "searchable": true
                } @role(['manager','support']) , {
                    "data": "action",
                    "name": "action",
                    "title": " ",
                    "orderable": true,
                    "searchable": true
                } @endrole ],
                "language": {"url": "https:\/\/cdn.datatables.net\/plug-ins\/1.10.25\/i18n\/Persian.json"},
                "stateSave": true,
                "order": [[0, "desc"]],
                "responsive": true,
                "autoWidth": true,
                "scrollX": false
            });

            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            LaravelDataTables["tickets-table"].on('click', '[data-destroy]', function (e) {
                e.preventDefault();
                if (!confirm("Are you sure to delete this record?")) {
                    return;
                }
                axios.delete($(this).data('destroy'), {
                    '_method': 'DELETE',
                })
                    .then(function (response) {
                        LaravelDataTables["tickets-table"].ajax.reload();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            });

        });
    </script>

@endpush
