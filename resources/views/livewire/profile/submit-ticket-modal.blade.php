<div wire:ignore.self class="modal fade" tabindex="-1" id="submit_ticket_for_user_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">ثبت تیکت جدید</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                     aria-label="Close">
                    <span class="fa fa-close"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <form id="submit_ticket_for_agent">

                    <div class="row px-0">
                        <!--begin::title input-->
                        <label for="title"
                               class="col-lg-4 col-form-label fs-6 fw-bolder">عنوان</label>
                        <input id="title" wire:model.defer="ticket.title"
                               class="form-control @error('ticket.title') is-invalid @enderror">
                        @error('ticket.title')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                    <!--end::title input-->
                    </div>

                    <div class="row px-0" wire:ignore>
                        <label for="priority"
                               class="col-lg-4 col-form-label fs-6 fw-bolder">اولویت</label>
                        <select id="priority" class="form-select">
                            <option value="" selected>انتخاب اولویت</option>
                            <option value="low">کم</option>
                            <option value="low">متوسط</option>
                            <option value="low">زیاد</option>
                        </select>
                    </div>

                    <div class="row px-0">
                        <!--begin::description input-->
                        <label for="message"
                               class=" col-lg-4 col-form-label fs-6 fw-bolder">متن تیکت</label>
                        <textarea id="message" wire:model.defer="message"
                                  class="form-control @error('message') is-invalid @enderror"></textarea>
                        @error('message')
                        <div class="invalid-feedback" role="alert">{{$message}}</div>
                    @enderror
                    <!--end::title input-->
                    </div>

                    <div class="row px-0">

                        <!--begin::Label-->
                        <label for="attachment"
                               class=" col-lg-6 col-form-label fs-6 fw-bolder">پیوست ( حداکثر حجم :‌ ۲ مگابایت )</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input id="attachment"
                               class="mb-2 form-control @error('attachment') is-invalid @enderror form-control-solid"
                               wire:model="attachment" type="file"/>
                        @error('attachment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <!--end::Input-->

                        <div class="d-flex" wire:loading.class="d-none" wire:target="attachment">
                            <div class="text-primary fw-semibold">پسوند های مجاز:</div>
                            <div class="mx-2"></div>
                            <div>jpg, gif, jpeg, png, pdf, docx, xlsx, csv, odt, zip, doc</div>
                        </div>

                        <!--begin::Progress-->
                        <div id="attachment_progress_parent" class="progress h-8px bg-light-primary mt-5 d-none"
                             wire:loading.class.remove="d-none" wire:target="attachment">
                            <div id="attachment_progress" class="progress-bar bg-primary" role="progressbar"
                                 style="width: 0%"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!--end::Progress-->
                        <div>
                           <span wire:loading.class="d-block" wire:target="attachment"
                                 class="indicator-progress mt-2">{{__('messages.Uploading')}}
															<span id="progress_number"
                                                                  class="align-middle ms-2">%0</span></span>
                        </div>
                    </div>

                </form>

            </div>


            <div class="modal-footer">
                <button type="button" wire:target="submitTicket" wire:loading.attr="disabled" class="btn btn-light" data-bs-dismiss="modal">انصراف</button>
                <!--begin::Button-->
                <button type="button" wire:click.prevent="submitTicket()" wire:loading.attr="disabled" class="btn btn-primary">
                    <span class="indicator-label" wire:target="submitTicket" wire:loading.class="d-none">ارسال</span>
                    <span class="indicator-progress" wire:target="submitTicket" wire:loading.class="d-block">در حال ارسال
														<span
                                                            class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Button-->
            </div>
        </div>
    </div>
</div>
@push('styles')
    <style>
        .select2-container{
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
    </style>
@endpush
@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            $('#priority').select2({
                placeholder: "انتخاب اولویت",
                dropdownParent: $('#submit_ticket_for_user_modal'),
            });

            $('#priority').on('select2:select', function (e) {
            @this.set('ticket.priority', e.target.value);
            });

            const submitTicketModal = document.getElementById('submit_ticket_for_user_modal')
            submitTicketModal.addEventListener('hidden.bs.modal', event => {
            @this.resetModal();
                $('#attachment').val('');
            });

            submitTicketModal.addEventListener('shown.bs.modal', event => {
                $("#priority").val("low").trigger('change');
            @this.set('ticket.priority', 'low');
            });

            document.addEventListener('toggleSubmitTicketModal', function () {
                $('#submit_ticket_for_user_modal').modal('toggle');
                let table = window.window.LaravelDataTables['tickets-table'];
                if (table) {
                    table.ajax.reload();
                }
            })

            $('#attachment').on('livewire-upload-start', function () {
                $('#attachment_progress').css('width', '0%');
                $('#progress_number').text('%0');
            });

            $('#attachment').on('livewire-upload-finish', function () {
                $('#attachment_progress').css('width', '0%');
                $('#progress_number').text('%0');
            });

            $('#attachment').on('livewire-upload-progress', function (event) {
                $('#attachment_progress').css('width', event.detail.progress + '%');
                $('#progress_number').text('%' + event.detail.progress);
            });
        })
    </script>
@endpush
