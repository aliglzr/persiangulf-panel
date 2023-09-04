<!--begin::Action--->
<td class="text-end">
    @can('edit-plan')
    <button class="btn btn-sm btn-icon btn-secondary mx-1" onclick="editPlan({{$model->id}})"><i class="fas fa-pen-to-square fs-4 "></i></button>
    @endcan
        @can('delete-plan')
        <button class="btn btn-sm btn-icon btn-danger mx-1" onclick="deletePlan({{$model->id}})"><i class="fas fa-trash-can fs-4 "></i></button>
            @endcan
</td>

