<div>
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
    @foreach($roles as $role)
    <!--begin::Col-->
    <div class="col-md-4">
        <!--begin::Card-->
        <div class="card card-flush h-md-100">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title">
                    <h2>{{$role->slug}} ( {{convertNumbers($role->users()->count())}} کاربر )</h2>
                </div>
                @if($role->name != 'manager' && $role->name != 'agent' && $role->name != 'client')
                    <div class="card-toolbar">
                        <div onclick="deleteRole({{$role->id}})">
                            <i class="fa fa-trash text-secondary text-hover-danger cursor-pointer"></i>
                        </div>
                    </div>
                    @endif
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-1">
                <!--begin::Permissions-->
                <div class="d-flex flex-column text-gray-600">
                    @foreach($role->permissions()->take(5)->get() as $permission)
                    <div class="d-flex align-items-center py-2">
                        <span class="bullet bg-primary me-3"></span>{{$permission->slug}}</div>
                    @endforeach
                    @if($role->permissions()->get()->count() > 5)
                    <div class="d-flex align-items-center py-2">
                        <span class="bullet bg-primary me-3"></span>
                        <em>و {{convertNumbers($role->permissions()->get()->count() - 5)}} دسترسی دیگر</em>
                    </div>
                        @endif
                </div>
                <!--end::Permissions-->
            </div>
            <!--end::Card body-->
            <!--begin::Card footer-->
            <div class="card-footer flex-wrap pt-0">
{{--                <a href="/metronic8/demo6/../demo6/apps/user-management/roles/view.html" class="btn btn-light btn-active-primary my-1 me-2">مشاهده دسترسی ها</a>--}}
                <button type="button" class="btn btn-light btn-active-light-primary my-1" onclick="editRole({{$role->id}})">ویرایش نقش</button>
            </div>
            <!--end::Card footer-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Col-->
    @endforeach
    <!--begin::Add new card-->
    <div class="ol-md-4">
        <!--begin::Card-->
        <div class="card h-md-100">
            <!--begin::Card body-->
            <div class="card-body d-flex flex-center">
                <!--begin::Button-->
                <button type="button" class="btn btn-clear d-flex flex-column flex-center" data-bs-toggle="modal" data-bs-target="#add_role">
                    <!--begin::Illustration-->
                    <img src="{{asset('media/illustrations/sketchy-1/4.png')}}" alt="" class="mw-100 mh-150px mb-7">
                    <!--end::Illustration-->
                    <!--begin::Label-->
                    <div class="fw-bold fs-3 text-gray-600 text-hover-primary">افزودن نقش جدید</div>
                    <!--end::Label-->
                </button>
                <!--begin::Button-->
            </div>
            <!--begin::Card body-->
        </div>
        <!--begin::Card-->
    </div>
    <!--begin::Add new card-->
</div>

    <livewire:role.create-modal />

</div>
    @push('scripts')
        <script>
            function deleteRole(id){
                Swal.fire({
                    icon: "question",
                    title: 'آیا از حذف این نقش اطمینان دارید؟',
                    showCancelButton: true,
                    confirmButtonText: 'بله',
                    cancelButtonText: 'خیر',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-secondary",
                    }
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                    @this.delete(id);
                    }
                })
            }
        </script>
@endpush
@section('title')
مدیریت نقش ها
@endsection
@section('description')
مدیریت نقش ها
@endsection
