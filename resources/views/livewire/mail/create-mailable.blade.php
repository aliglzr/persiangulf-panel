<div wire:ignore.self class="modal fade" id="createMailable">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ساخت ایمیل جدید</h5>
            </div>
            <div class="modal-body">
                <form class="form" wire:submit.prevent="create()">
                    @csrf
                    <div class="form-group">
                        <label for="name"
                               class="col-form-label fs-6 fw-bolder">عنوان ایمیل</label>
                        <input wire:model.lazy="name" type="name" id="name" class="form-control @error('name') is-invalid @enderror mt-2" placeholder="عنوان ایمیل" aria-label="عنوان ایمیل"
                               aria-describedby="basic-addon1"/>
                        <div class="text-gray-800 mt-2">عنوان ایمیل را به انگلیسی وارد کنید برای مثال <span class="fw-bold text-primary">WelcomeUser یا Welcome User</span></div>
                        @error('name')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <!--begin::Options-->
                        <div class="d-flex align-items-center mt-3">
                            <!--begin::Option-->
                            <label class="form-check form-check-custom form-check-inline form-check-solid">
                                <input class="form-check-input" wire:model.lazy="force" type="checkbox" value="true">
                                <span class="fw-semibold ps-2 fs-6">الزام به ساخت</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="ایجاد ایمیل در صورت وجود داشتن آن"></i>
                            </label>
                            <!--end::Option-->
                        </div>
                        <!--end::Options-->
                        <div class="fv-plugins-message-container invalid-feedback"></div></div>

                    <div class="modal-footer d-flex justify-content-center align-items-center flex-row-reverse"
                         style="border-top-width: 0 !important;">
                        <button type="submit" class="btn btn-primary">

                            <!--begin::Indicator-->
                            <span class="indicator-label" wire:target="create" wire:loading.class="d-none">
    ایجاد
</span>
                            <span class="indicator-progress" wire:target="create" wire:loading.class="d-block">
    در حال ایجاد
    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
</span>
                            <!--end::Indicator-->
                        </button>
                        <button type="button" class="btn btn-secondary font-weight-bold" data-bs-dismiss="modal"
                                aria-label="Close">انصراف
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const createMailableModal = document.getElementById('createMailable')
        createMailableModal.addEventListener('hidden.bs.modal', event => {
        @this.resetModal();
        });

        document.addEventListener('toggleCreateMailableModal', function () {
            $('#sendTestMail').modal('toggle');
            let table = window.window.LaravelDataTables['mailables-table'];
            if (table) {
                table.ajax.reload();
            }
        });
    </script>
@endpush