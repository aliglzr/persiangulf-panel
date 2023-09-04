<!--begin::Action--->
<td class="text-end">
    @can('modify-server')
        <button class="btn btn-sm btn-icon btn-secondary mx-1" onclick="editServer({{$model->id}})"><i
                class="fas fa-pen-to-square fs-4 "></i></button>
    @endcan
    @can('delete-server')
        <button class="btn btn-sm btn-icon btn-danger mx-1" onclick="deleteServer({{$model->id}})"><i
                class="fas fa-trash-can fs-4 "></i></button>
    @endcan
    @can('change-server-layer')
                    <button class="btn btn-sm btn-icon btn-info mx-1" onclick="setModel({{$model->id}},'server')"><i
                                    class="bi bi-layers-half fs-4 "></i></button>
    @endcan
</td>


