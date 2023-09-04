<div wire:ignore.self class="modal fade" id="sendTestMail">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ارسال ایمیل تست</h5>
            </div>
            <div class="modal-body">
                <form class="form" wire:submit.prevent="sendTest()">
                    @csrf
                    <div class="form-group">
                        <label for="password"
                               class="col-form-label fs-6 fw-bolder">آدرس ایمیل دریافت کننده</label>
                            <input wire:model.lazy="recipientMail" type="email" id="inc_balance_input" class="form-control @error('recipientMail') is-invalid @enderror mt-5" placeholder="آدرس ایمیل دریافت کننده" aria-label="آدرس ایمیل دریافت کننده"
                                   aria-describedby="basic-addon1"/>
                        @error('recipientMail')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center flex-row-reverse"
                         style="border-top-width: 0 !important;">
                        <button type="submit" class="btn btn-primary">

                            <!--begin::Indicator-->
                            <span class="indicator-label" wire:target="sendTest" wire:loading.class="d-none">
    ارسال
</span>
                            <span class="indicator-progress" wire:target="sendTest" wire:loading.class="d-block">
    در حال ارسال
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
        const sendTestMailModal = document.getElementById('sendTestMail')
        sendTestMailModal.addEventListener('hidden.bs.modal', event => {
        @this.resetModal();
        });

        document.addEventListener('toggleSendTestMailModal', function () {
            $('#sendTestMail').modal('toggle');
        });
    </script>
    @endpush
