<div class="table-responsive">
    @if($tickets->count())
    <table id="kt_datatable_zero_configuration"
           class="table table-rounded table-striped border gy-7 gs-7 align-middle">
        <thead>
        <tr class="fw-semibold fs-4 text-gray-800 border-bottom border-gray-200">
            <th>شماره</th>
            <th>عنوان</th>
            <th>تاریخ</th>
            <th>وضعیت</th>
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tickets as $ticket)
            <tr>
                <td>{{convertNumbers($ticket->ticket_id)}}</td>
                <td>{{Str::limit($ticket->title, 20)}}</td>
                <td>{{convertNumbers(\Hekmatinasser\Verta\Verta::instance($ticket->updated_at)->format('j F Y H:i:s'))}}</td>
                <td><span class="badge badge-{{$ticket->getTicketStatus()['color']}}">{{$ticket->getTicketStatus()['status']}}</span></td>
                <td><a href="{{route('support.show',['user' => $ticket->user,'ticket' => $ticket])}}" class="btn btn-link btn-color-primary btn-active-color-dark">مشاهده
                        تیکت</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @else
    <div class="d-flex flex-column justify-content-center align-content-center align-items-center">
        <img src="{{asset('media/illustrations/sigma-1/4.png')}}" class="w-200px h-200px" alt="">
        <div class="fw-semibold fs-3">تیکتی یافت نشد</div>
        @role(['client','agent'])
        <button class="btn btn-light-primary mt-3" data-bs-toggle="modal" data-bs-target="#submit_ticket_modal">ثبت تیکت</button>
        @endrole
    </div>
        @endif
</div>
