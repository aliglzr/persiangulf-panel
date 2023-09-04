<!--begin::Action--->
<td class="text-end">
    @can('modify-domain')
        <button class="btn btn-sm btn-icon btn-secondary mx-1" onclick="editDomain({{$model->id}})"><i
                class="fas fa-pen-to-square fs-4 "></i></button>
    @endcan
    @can('delete-domain')
        <button class="btn btn-sm btn-icon btn-danger mx-1" onclick="deleteDomain({{$model->id}})"><i
                class="fas fa-trash-can fs-4 "></i></button>
    @endcan
</td>


