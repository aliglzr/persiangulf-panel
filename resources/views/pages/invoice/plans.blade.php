<td>
    @if(!$invoice->user->isClient())
    @foreach($invoice->planUsers()->get() as $planUser)
        <span class="badge badge-light-primary fs-7 me-3 {{$loop->index == 0 ? 'ms-3' : ''}}">{{$planUser->plan_title}}</span>
    @endforeach
    @else
        <span class="badge badge-light-primary fs-7 me-3 ms-3">{{\App\Models\Subscription::where('invoice_id',$invoice->id)->first()?->planUser?->plan_title}}</span>
    @endif
</td>
