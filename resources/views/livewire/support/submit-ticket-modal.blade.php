<div wire:ignore.self class="modal fade" tabindex="-1" id="submit_ticket_modal">
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

                    <div class="row">
                        <div>
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
                    </div>

                    <div class="row">
                        <div wire:ignore>
                            <!--begin::team input-->
                            <label for="category_id"
                                   class=" col-lg-4 col-form-label fs-6 fw-bolder">واحد</label>
                            <select id="category_id" class="form-select"
                                    data-placeholder="انتخاب واحد">
                                @foreach(\Coderflex\LaravelTicket\Models\Category::all() as $category)
                                    <option value="{{$category->id}}" {{$category->id == 1 ? 'selected' : ''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id')
                        <div class="text-danger mt-2">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::team input-->

                    <div class="row">
                        <div wire:ignore>
                            <!--begin::team input-->
                            <label for="priority"
                                   class="col-lg-4 col-form-label fs-6 fw-bolder">اولویت</label>
                            <select id="priority" class="form-select"
                                    data-placeholder="انتخاب اولویت">
                                <!--TODO : set correct roles -->
                                <option value="low" selected>کم</option>
                                <option value="medium">متوسط</option>
                                <option value="high">زیاد</option>
                            </select>
                        </div>
                        @error('ticket.priority')
                        <div class="text-danger mt-2">{{$message}}</div>
                        @enderror
                    </div>
                    <!--end::team input-->


                    <div class="row">
                        <div>
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
                    </div>

                    <div class="row">
                        <div>
                            <!--begin::Label-->
                            <label for="attachment"
                                   class=" col-lg-6 col-form-label fs-6 fw-bolder">پیوست ( حداکثر حجم :‌ ۲ مگابایت
                                )</label>
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
                    </div>

                </div>


                <div class="modal-footer">
                    <button type="button" wire:target="submitTicket" wire:loading.attr="disabled" class="btn btn-light"
                            data-bs-dismiss="modal">انصراف
                    </button>
                    <button type="button" wire:click.prevent="submitTicket()" wire:loading.attr="disabled"
                            class="btn btn-primary">
                        <span class="indicator-label" wire:target="submitTicket"
                              wire:loading.class="d-none">ارسال</span>
                        <span class="indicator-progress" wire:target="submitTicket" wire:loading.class="d-block">در حال ارسال
														<span
                                                            class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @push('styles')
        <style>
            .select2-container {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
        </style>
    @endpush
    @push('scripts')
        <script>
            document.addEventListener('livewire:load', function () {
                $('#category_id').select2({
                    dropdownParent: $('#submit_ticket_modal')
                });
                $('#priority').select2({
                    dropdownParent: $('#submit_ticket_modal'),
                });

                $('#category_id').on('select2:select', function (e) {
                @this.set('category_id', e.target.value);
                });

                $('#priority').on('select2:select', function (e) {
                @this.set('ticket.priority', e.target.value);
                });

                $($("#category_id").select2("container")).addClass("px-0");
                $($("#priority").select2("container")).addClass("px-0");


                const submitTicketModal = document.getElementById('submit_ticket_modal')
                submitTicketModal.addEventListener('hidden.bs.modal', event => {
                @this.resetModal();
                    $("#priority").val("low").trigger('change');
                @this.set('ticket.priority', 'low');
                    $("#category_id").val("1").trigger('change');
                @this.set('category_id', 1);
                });
                submitTicketModal.addEventListener('shown.bs.modal', event => {
                    $("#priority").val("low").trigger('change');
                @this.set('ticket.priority', 'low');
                    $("#category_id").val("1").trigger('change');
                @this.set('category_id', 1);
                });

                document.addEventListener('toggleSubmitTicketModal', function () {
                    $('#submit_ticket_modal').modal('toggle');
                    let table = window.window.LaravelDataTables['tickets-table'];
                    if (table) {
                        table.ajax.reload();
                    }
                })

                $('#category_id').on('select2:select', function (e) {
                @this.set('category_id', e.target.value);
                });

                $('#priority').on('select2:select', function (e) {
                @this.set('ticket.priority', e.target.value);
                });

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
