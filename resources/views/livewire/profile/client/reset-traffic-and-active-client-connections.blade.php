<div wire:ignore.self class="modal fade" tabindex="-1" id="reset_traffic_and_active_client_connections_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-gray-900">شما در حال ریست کردن ترافیک و فعالسازی کانکشن های حساب کاربری <span class="text-primary fw-bolder">{{$user->username}}</span> هستید</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                     aria-label="Close">
                    <span class="svg-icon svg-icon-1"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <label for="password"
                       class=" col-lg-4 col-form-label fs-6 fw-bolder">دلیل انجام عملیات</label>
                <textarea wire:model.lazy="description" class="form-control @error('description') is-invalid @enderror"></textarea>
                @error('description')
                <div class="invalid-feedback" role="alert">{{$message}}</div>
                @enderror

                <label for="delete_user"
                       class=" col-lg-4 col-form-label fs-6 fw-bolder">تایپ عبارت reset client</label>
                <input wire:model.lazy="reset_client" class="form-control @error('reset_client') is-invalid @enderror">
                <small class="text-muted fw-bold">جهت حذف کاربر عبارت <span class="text-danger fw-bolder">reset client</span> را تایپ کنید</small>
                @error('reset_client')
                <div class="invalid-feedback" role="alert">{{$message}}</div>
                @enderror

            </div>


            <div class="modal-footer {{$reset ? 'd-none' : ''}}">
                <button type="button" class="btn btn-primary" wire:target="resetClientTraffic" wire:loading.attr="disabled" data-bs-dismiss="modal">انصراف</button>
                <button wire:click.prevent="resetClientTraffic()" wire:target="resetClientTraffic" wire:loading.attr="disabled" class="btn btn-danger" id="reset_traffic_and_active_client_connections_submit">
               <span class="indicator-label" wire:target="resetClientTraffic" wire:loading.class="d-none" >
 ریست
               </span>
                    <span class="indicator-progress" wire:target="resetClientTraffic" wire:loading.class="d-block">
                        در حال ریست
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
</span>
                </button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('closeResetTrafficAndActiveConnectionsModal',function () {
            $('#reset_traffic_and_active_client_connections_modal').modal('hide');
        })
    </script>
@endpush
