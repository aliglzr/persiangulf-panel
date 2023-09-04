<!--begin::Action--->
<td class="text-end">

    @can('edit-discount')
    <button class="btn btn-sm btn-icon btn-secondary mx-1" onclick="editDiscount({{$model->id}})"><i class="fas fa-pen-to-square fs-4 "></i></button>
    @endcan

    @can('delete-discount')
    <button class="btn btn-sm btn-icon btn-danger mx-1" onclick="deleteDiscount({{$model->id}})"><i class="fas fa-trash-can fs-4 "></i></button>
        @endcan

</td>


