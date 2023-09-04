<!--begin::Action--->
<td class="text-end">
    @can('toggle-ticket-status')
    @if(!$ticket->isLocked())
            <button onclick="toggleLockingTicket({{$ticket->id}})"
                    class="btn btn-sm btn-icon btn-icon-success opacity-25 opacity-100-hover  mx-1"
                    title="قفل کردن تیکت"><i class="fas fa-lock-open fs-4"></i></button>
        @else
            <button onclick="toggleLockingTicket({{$ticket->id}})"
                    class="btn btn-sm btn-icon btn-icon-danger opacity-25 opacity-100-hover mx-1"
                    title="باز کردن تیکت"><i class="fas fa-lock fs-4"></i></button>
    @endif

    @if(!$ticket->isResolved())
            <button onclick="toggleResolvingTicket({{$ticket->id}})"
                    class="btn btn-sm btn-icon btn-icon-secondary mx-1"
                    title="تغییر وضعیت به حل شده"><i class="fas fa-check fs-4"></i></button>
        @else
            <button class="btn btn-sm btn-icon btn-icon-success opacity-25 mx-1"
                    title="حل شده"><i class="fas fa-check fs-4"></i></button>
    @endif
    @endcan
</td>



