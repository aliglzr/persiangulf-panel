<!--begin::Action--->
<td class="text-end">
    @if(auth()->user()->isManager())
        <button class="btn btn-sm btn-icon btn-secondary mx-1" onclick="editSubscription({{$model->id}})"><i
                class="fas fa-pen-to-square fs-4 "></i></button>
    @endif
</td>


