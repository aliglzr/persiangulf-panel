<!--begin::Action--->
<td class="text-end">
    @if(auth()->user()->id == $model->user->id || auth()->user()->can('view-invoice'))
    <a href="{{route('invoices.show',$model)}}" class="btn btn-sm btn-light btn-active-light-primary">
جزییات
    </a>
        @endif
</td>



