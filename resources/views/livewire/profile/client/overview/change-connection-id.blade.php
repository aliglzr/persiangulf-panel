<div wire:ignore.self class="modal fade" tabindex="-1" id="change_connection_id">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">غیرفعال کردن کانکشن های قبلی</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                     aria-label="Close">
                    <span class="fa fa-close"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <h5>کاربر گرامی</h5>
                <p style="text-align: justify;line-height: 150%" class="mt-5">با استفاده از این قابلیت، می‌توانید در مواقعی که اطلاعات کانفیگ شما لو رفته و می‌خواهید دستگاه‌های ناشناسی که به آن متصل شده‌اند، قطع شوند، کانکشن قبلی خود را غیرفعال نمایید.</p>
                @include('partials.general._notice',['color' => 'warning','icon' => 'icons/duotune/general/gen044.svg','title' => 'توجه','body' => 'در صورت انجام این عملیت تمامی کانکشن های دریافت شده قبلی، غیر فعال خواهند شد و جهت اتصال باید مجددا کانفیگ دریافت کنید ','class' => 'mt-5'])
                @include('partials.general._notice',['color' => 'danger','icon' => 'icons/duotune/general/gen044.svg','body' => 'هر هفته تنها یکبار مجاز به انجام این عملیات هستید','class' => 'mt-5'])
            </div>


            <div class="modal-footer">
                <button type="button" wire:target="changeConnectionId" wire:loading.attr="disabled" class="btn btn-light" data-bs-dismiss="modal">انصراف</button>
                <!--begin::Button-->
                <button type="button" wire:click.prevent="changeConnectionId()" wire:loading.attr="disabled" class="btn btn-warning">
                    <span class="indicator-label" wire:target="changeConnectionId" wire:loading.class="d-none">غیر فعال سازی</span>
                    <span class="indicator-progress" wire:target="changeConnectionId" wire:loading.class="d-block">در حال پردازش
														<span
                                                            class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Button-->
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('toggleChangeConnectionIdModal', function () {
            $('#change_connection_id').modal('toggle');
        })
    </script>
@endpush
