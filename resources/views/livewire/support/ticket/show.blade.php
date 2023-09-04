<div class="card w-100 rounded-0 border-0">
    <!--begin::Card header-->
    <div class="card-header p-5">
        <!--begin::Title-->
        <div class="card-title">
            <!--begin::User-->
            <div class="d-flex justify-content-center flex-column mx-3">
               <span> <a href="#"
                         class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1">{{$ticket->title}}</a>
                @if(!$ticket->isClosed() && !$ticket->isLocked())
                       <span
                               class="d-inline-flex flex-center p-0 h-10px w-10px pulse pulse-success ms-3 me-1">
                  <span class="bullet bullet-dot bg-success h-10px w-10px"></span>
                  <span class="pulse-ring"></span>
                </span> <span class="fs-6 text-success">گفتگوی آنلاین</span>
                   @endif </span>
                <!--begin::Info-->
                <div class="mb-0 lh-1 mt-2 d-flex flex-column flex-md-row align-items-md-baseline">
                    <div class="badge badge-light-primary p-3">
                        <span class="me-1 fs-6 text-dark">وضعیت تیکت:</span>
                        <span
                                class="fs-7 fw-semibold text-{{$ticket->getTicketStatus()['color']}}">{{$ticket->getTicketStatus()['status']}}</span>
                    </div>
                    <div class="my-2 my-md-0 mx-md-5"></div>
                    <div class="badge badge-light-primary p-3">
                        <span class="me-1 fs-6 text-dark">کد رهگیری:</span>
                        <span class="fs-7 fw-semibold text-primary">{{$ticket->ticket_id}}</span>
                    </div>
                    <div class="my-2 my-md-0 mx-md-5"></div>
                    <div class="badge badge-light-primary p-3">
                        <span class="me-1 fs-6 text-dark">واحد پاسخگو:</span>
                        <span class="fs-7 fw-semibold text-primary">{{$ticket->category->name}}</span>
                    </div>
                </div>

                <!--end::Info-->
            </div>
            <!--end::User-->
        </div>

        <!--end::Title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <div class="me-2">
                @if((auth()->user()->id == $ticket->user->id || auth()->user()->hasRole('support') || auth()->user()->isManager()) && (!$ticket->isClosed() && !$ticket->isLocked()))
                    <button class="btn btn-sm btn-icon btn-active-light-primary" data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end">
                        <i class="bi bi-three-dots fs-3"></i>
                    </button>
                    <!--begin::Menu 3-->
                    <div wire:ignore
                         class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                         data-kt-menu="true" style="">
                        <!--begin::Heading-->
                        <div class="menu-item px-3">
                            <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">عملیات</div>
                        </div>
                        <!--end::Heading-->
                        @role(['support','manager'])
                        <!--begin::Menu item-->
                        <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                            <a href="#" class="menu-link px-3">
                                <span class="menu-title">تغییر وضعیت تیکت به</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <!--begin::Menu sub-->
                            <div class="menu-sub menu-sub-dropdown w-175px py-4" style="">
                                @if($ticket->status != 'processing')
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a wire:click.prevent="setTicketStatusToProcessing()" class="menu-link px-3">در
                                            حال بررسی</a>
                                    </div>
                                    <!--end::Menu item-->
                                @endif
                                @if(!$ticket->isResolved())
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a wire:click.prevent="markTicketAsResolved()" class="menu-link px-3">حل شده</a>
                                    </div>
                                    <!--end::Menu item-->
                                @endif
                            </div>
                            <!--end::Menu sub-->
                        </div>
                        <!--end::Menu item-->

                        <!--start::Menu item-->
                        <div class="menu-item px-3 my-1">
                            <a class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#changeCategoryModal"
                               data-bs-placement="top"
                               aria-label="ارجاع به واحد دیگر"
                               title="ارجاع به واحد دیگر">ارجاع به واحد دیگر</a>
                        </div>
                        <!--end::Menu item-->
                        @endrole

                        <!--start::Menu item-->
                        <div class="menu-item px-3 my-1">
                            <a class="menu-link px-3 text-danger bg-hover-light-danger" id="close_ticket_button"
                               data-bs-toggle="tooltip"
                               data-bs-placement="top"
                               aria-label="بستن تیکت"
                               title="بستن تیکت">بستن تیکت</a>
                        </div>
                        <!--end::Menu item-->

                    </div>
                    <!--end::Menu 3-->
                @endif
                <a href="{{route('support.tickets')}}" class="btn btn-sm btn-icon btn-active-light-primary"
                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <i class="fa fa-arrow-left fs-3"></i>
                </a>
            </div>
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body" id="kt_drawer_chat_messenger_body">
        <!--begin::Messages-->
        <div wire:ignore.self class="scroll scroll-y me-n5 pe-5 h-md-200px h-lg-400px" data-kt-element="messages"
             data-kt-scroll="true" data-kt-scroll-activate="true"
             data-kt-scroll-height="auto" id="kt_scroll"
             data-kt-scroll-dependencies="#kt_drawer_chat_messenger_header, #kt_drawer_chat_messenger_footer"
             data-kt-scroll-wrappers="#kt_drawer_chat_messenger_body" data-kt-scroll-offset="0px">
            <!--begin::Message(in)-->
            @php
                $previousLocation = null;
            @endphp
            @foreach($ticketMessages as $message)
                @php
                    $hasRightLocation = ( $message->user_id == auth()->user()->id || ((auth()->user()->hasRole('support') || auth()->user()->isManager()) && ($message->user->hasRole('support') || $message->user->isManager()))  );
                @endphp
                <div class="d-flex justify-content-{{$hasRightLocation ? 'start' : 'end'}} @if($hasRightLocation !== $previousLocation) mt-10 @endif">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column align-items-start">
                        <!--begin::User-->
                        <div class="d-flex align-items-center mb-2">
                            @if($hasRightLocation !== $previousLocation)
                                <!--begin::Details-->
                                <div dir="ltr">
                                <span dir="rtl"
                                      class="text-muted fw-semibold fs-7 mb-1">{{convertNumbers(\Carbon\Carbon::instance($message->created_at)->diffForHumans())}}</span>
                                    <a href="{{(!auth()->user()->isManager() && !auth()->user()->isSupport()) ? '#' : $message->user->getProfileLink()}}"
                                       class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">{{($message->user->isManager() || $message->user->isSupport()) ? auth()->user()->isManager() || auth()->user()->isSupport() ? $message->user->username : convertNumbers($ticket->assignedUser->id)." پشتیبانی شماره " : $message->user->username }}</a>
                                </div>
                                <!--end::Details-->
                            @endif
                        </div>
                        @if($hasRightLocation !== $previousLocation)
                            @if((auth()->user()->isManager() || auth()->user()->isSupport()) && (!$message->user->isManager() && !$message->user->isSupport()))
                                <div class="text-gray-800 fw-semibold fs-7 mb-1">{{$message->user->full_name}}</div>
                            @endif
                        @endif
                        <!--end::User-->
                        <!--begin::Text-->
                        <div
                                class="p-5 rounded bg-light-{{$hasRightLocation ? 'secondary' : 'primary'}} text-dark fw-semibold mw-300px mw-lg-500px text-start"
                                {{--                            data-kt-element="message-text">{!! str_replace("\n","<br>",$message->message) !!}</div>--}}
                                data-kt-element="message-text">{!!str_replace('[br]','<br>',$message->message)!!}</div>
                        <!--end::Text-->
                        @if($message->getFirstMedia())
                            <div class="d-flex mt-2">
                                <a rel="nofollow" target="_blank" href="{{$message->getFirstMedia()->getTempUrl()}}"
                                   class="fw-semibold">فایل پیوست</a>
                            </div>
                        @endif
                    </div>
                    <!--end::Wrapper-->
                </div>
                @php
                    $previousLocation = $hasRightLocation;
                @endphp
            @endforeach
            @if($ticket->is_reviewed)
                @php
                    $hasRightLocation = ( $ticket->user_id == auth()->user()->id || ((auth()->user()->hasRole('support') || auth()->user()->isManager()) && ($ticket->user->hasRole('support') || $ticket->user->isManager()))  );
                @endphp
                <div class="d-flex justify-content-{{$hasRightLocation ? 'start' : 'end'}} mb-10">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column align-items-start">
                        <!--begin::User-->
                        <div class="d-flex align-items-center mb-2">
                            <!--begin::Details-->
                            <div dir="ltr">
                                <span dir="rtl"
                                      class="text-muted fw-semibold fs-7 mb-1">{{convertNumbers(\Carbon\Carbon::instance($ticket->updated_at)->diffForHumans())}}</span>
                                <a href="{{(!auth()->user()->isManager() && !auth()->user()->isSupport()) ? '' : $ticket->user->getProfileLink()}}"
                                   class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">{{ $ticket->user_id == auth()->user()->id ? 'نظر شما' : 'نظر کاربر'  }}</a>
                            </div>
                            <!--end::Details-->
                        </div>
                        <!--end::User-->
                        <!--begin::Text-->
                        @if($ticket->review)
                            <div
                                    class="p-5 rounded bg-light-{{$hasRightLocation ? 'secondary' : 'primary'}} text-dark fw-semibold mw-300px mw-lg-500px text-start"
                                    {{--                            data-kt-element="message-text">{!! str_replace("\n","<br>",$message->message) !!}</div>--}}
                                    data-kt-element="message-text">{{ $ticket->review }}</div>
                        @endif

                        <div class="d-flex mt-2">
                            @if($ticket->rating)
                                @foreach(range(1,$ticket->rating) as $star)
                                    <span class="svg-icon svg-icon-1 text-warning"><svg width="24" height="24"
                                                                                        viewBox="0 0 24 24" fill="none"
                                                                                        xmlns="http://www.w3.org/2000/svg">
																<path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z"
                                                                      fill="currentColor"></path>
															</svg></span>
                                @endforeach
                            @else
                                <span class="badge badge-light-secondary">بدون امتیاز</span>
                            @endif
                        </div>
                        <!--end::Text-->
                    </div>
                    <!--end::Wrapper-->
                </div>
            @endif
        </div>
        <!--end::Messages-->
    </div>
    <!--end::Card body-->
    <!--begin::Card footer-->
    <div class="card-footer pt-4">

        @if($ticket->status == 'closed')
            <div class="text-center pt-3 fs-4 fw-semibold text-gray-600">
                این تیکت بسته شده است
                @if(!$ticket->is_reviewed && $ticket->user_id == auth()->user()->id)
                    <a
                            class="text-primary cursor-pointer"
                            onclick="submitReviewForm()">ثبت نظر</a>
                @endif
            </div>
        @elseif($ticket->isLocked())
            <div class="text-center pt-3 fs-4 fw-semibold text-gray-600">این تیکت قفل شده است</div>
        @else
            <!--begin::Input-->
            <textarea wire:model.defer="message" id="message"
                      class="form-control form-control-flush @error('message') is-invalid @enderror mb-3" rows="3"
                      data-kt-element="input" placeholder="اینجا تایپ کنید..."></textarea>
            @error('message')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
            <!--end::Input-->
            <!--begin:Toolbar-->
            <div class="d-flex flex-stack">
                <!--begin::Actions-->
                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center me-2">
                    <button id="attachment_button" class="btn btn-sm btn-icon btn-active-light-primary me-1"
                            type="button"
                            data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Coming soon"
                            title="افزودن فایل پیوست">
                        <i class="bi bi-paperclip fs-3"></i>
                    </button>
                    <span wire:ignore class="mx-2 mt-5 mt-md-0" id="fileName"></span>
                    <input wire:model="attachment" id="ticket_attachment" type="file" class="invisible">
                </div>
                <!--end::Actions-->
                <!--begin::Send-->
                <button type="submit" wire:click.prevent="reply()" wire:loading.attr="disabled"
                        class="btn btn-primary d-none d-md-block">
                    <span class="indicator-label" wire:target="reply" wire:loading.class="d-none">ارسال</span>
                    <span class="indicator-progress" wire:target="reply" wire:loading.class="d-block">در حال ارسال
														<span
                                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Send-->
            </div>
            <!--end::Toolbar-->
            <div class="d-flex" wire:loading.class="d-none" wire:target="attachment">
                <div class="text-primary fw-semibold">پسوند های مجاز:</div>
                <div class="mx-2"></div>
                <div>jpg, gif, jpeg, png, pdf, docx, xlsx, csv, odt, zip, doc</div>
            </div>

            @error('attachment')
            <div class="d-block text-danger mt-2" wire:loading.class="d-none" wire:target="attachment">
                {{$message}}
            </div>
            @enderror

            <!--begin::Progress-->
            <div id="attachment_progress_parent" class="progress h-8px bg-light-primary mt-5 d-none w-lg-25"
                 wire:loading.class.remove="d-none" wire:target="attachment">
                <div id="attachment_progress" class="progress-bar bg-primary" role="progressbar" style="width: 0%"
                     aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <!--end::Progress-->
            <div>
                           <span wire:loading.class="d-block" wire:target="attachment"
                                 class="indicator-progress mt-2">{{__('messages.Uploading')}}
															<span id="progress_number"
                                                                  class="align-middle ms-2">%0</span></span>
            </div>
        @endif
        <button id="reply" type="submit" wire:click.prevent="reply()" wire:loading.attr="disabled"
                class="btn btn-primary mt-5 d-md-none">
            <span class="indicator-label" wire:target="reply" wire:loading.class="d-none">ارسال</span>
            <span class="indicator-progress" wire:target="reply" wire:loading.class="d-block">در حال ارسال
														<span
                                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
    </div>
    <!--end::Card footer-->
</div>

@push('scripts')
    <script>
        $('#attachment_button').click(function () {
            $("#ticket_attachment").trigger('click');
        });
        $('input[type="file"]').on('change', function (event) {
            $(this).siblings('span').text(event.target.files[0].name);
        })

        document.querySelector('#message').addEventListener('keydown', function (e) {
            if (e.keyCode === 13 || e.keyCode === 10) {
                // Ctrl + Enter
                if (e.ctrlKey) {
                    document.getElementById('reply').click();
                }
            }
        });

        function submitReviewForm() {
            Swal.fire({
                html: `<div class="d-flex justify-content-center align-items-center flex-column">
                       @role(['client','agent'])
                <div class="fs-5 fw-bold text-dark mt-5">لطفا امتیاز و نظر خود را ثبت کنید</div>
                    <div class="rating mt-2" dir="ltr">
            <label class="rating-label" for="kt_rating_input_1">
            <span class="svg-icon svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"></path>
                                                    </svg></span>
            </label>
            <input class="rating-input" name="rating" value="1" onclick="setRating(1)" type="radio" id="kt_rating_input_1"/>
            <label class="rating-label" for="kt_rating_input_2">
            <span class="svg-icon svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"></path>
                                                    </svg></span>
            </label>
            <input class="rating-input" name="rating" value="2" onclick="setRating(2)" type="radio" id="kt_rating_input_2"/>
            <label class="rating-label" for="kt_rating_input_3">
            <span class="svg-icon svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"></path>
                                                    </svg></span>
            </label>
            <input class="rating-input" name="rating" value="3" onclick="setRating(3)" type="radio" id="kt_rating_input_3"/>
            <label class="rating-label" for="kt_rating_input_4">
            <span class="svg-icon svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"></path>
                                                    </svg></span>
            </label>
            <input class="rating-input" name="rating" value="4" onclick="setRating(4)" type="radio" id="kt_rating_input_4"/>
            <label class="rating-label" for="kt_rating_input_5">
            <span class="svg-icon svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"></path>
                                                    </svg></span>
            </label>
            <input class="rating-input" name="rating" value="5" onclick="setRating(5)" type="radio" id="kt_rating_input_5"/>
            </div><textarea maxlength="1000" class="form-control mt-3" placeholder="پیشنهاد یا نظر شما در رابطه با این تیکت" id="review" ></textarea>@endrole
                </div>`,
                buttonsStyling: false,
                showCancelButton: false,
                confirmButtonText: "ثبت",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: 'btn btn-secondary'
                }
            }).then(async (result) => {
                if (result.isConfirmed) {
                    await @this.
                    set('review', $('#review').val());
                    await @this.
                    submitReview();
                }
            });
        }


        document.addEventListener('livewire:load', function () {
            @if(!auth()->user()->isManager() && !auth()->user()->isSupport() && !$ticket->is_reviewed)
            var submit_review = @this.
            submit_review;
            if (submit_review !== '') {
                submitReviewForm();
            }
            @endif
            var scroll = $('#kt_scroll');
            scroll.scrollTop(parseInt(scroll.prop('scrollHeight')));

            $('#ticket_attachment').on('livewire-upload-start', function () {
                $('#attachment_progress').css('width', '0%');
                $('#progress_number').text('%0');
            });
            $('#ticket_attachment').on('livewire-upload-finish', function () {
                $('#attachment_progress').css('width', '0%');
                $('#progress_number').text('%0');
            });
            $('#ticket_attachment').on('livewire-upload-progress', function (event) {
                console.log(event.detail.progress);
                $('#attachment_progress').css('width', event.detail.progress + '%');
                $('#progress_number').text('%' + event.detail.progress);
            });

            $('#close_ticket_button').on('click', function () {
                Swal.fire({
                    html: `<div class="d-flex justify-content-center align-items-center flex-column">
                        <div class="fs-2 fw-bold text-primary">آیا از بستن تیکت مطمئن هستید ؟</div>
                       @role(['client','agent'])
                    <div class="fs-5 fw-bold text-dark mt-5">لطفا پیش از بستن تیکت، امتیاز و نظر خود را ثبت کنید</div>
                        <div class="rating mt-2" dir="ltr">
                <label class="rating-label" for="kt_rating_input_1">
                <span class="svg-icon svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"></path>
                                                        </svg></span>
                </label>
                <input class="rating-input" name="rating" value="1" onclick="setRating(1)" type="radio" id="kt_rating_input_1"/>
                <label class="rating-label" for="kt_rating_input_2">
                <span class="svg-icon svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"></path>
                                                        </svg></span>
                </label>
                <input class="rating-input" name="rating" value="2" onclick="setRating(2)" type="radio" id="kt_rating_input_2"/>
                <label class="rating-label" for="kt_rating_input_3">
                <span class="svg-icon svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"></path>
                                                        </svg></span>
                </label>
                <input class="rating-input" name="rating" value="3" onclick="setRating(3)" type="radio" id="kt_rating_input_3"/>
                <label class="rating-label" for="kt_rating_input_4">
                <span class="svg-icon svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"></path>
                                                        </svg></span>
                </label>
                <input class="rating-input" name="rating" value="4" onclick="setRating(4)" type="radio" id="kt_rating_input_4"/>
                <label class="rating-label" for="kt_rating_input_5">
                <span class="svg-icon svg-icon-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.1359 4.48359C11.5216 3.82132 12.4784 3.82132 12.8641 4.48359L15.011 8.16962C15.1523 8.41222 15.3891 8.58425 15.6635 8.64367L19.8326 9.54646C20.5816 9.70867 20.8773 10.6186 20.3666 11.1901L17.5244 14.371C17.3374 14.5803 17.2469 14.8587 17.2752 15.138L17.7049 19.382C17.7821 20.1445 17.0081 20.7069 16.3067 20.3978L12.4032 18.6777C12.1463 18.5645 11.8537 18.5645 11.5968 18.6777L7.69326 20.3978C6.99192 20.7069 6.21789 20.1445 6.2951 19.382L6.7248 15.138C6.75308 14.8587 6.66264 14.5803 6.47558 14.371L3.63339 11.1901C3.12273 10.6186 3.41838 9.70867 4.16744 9.54646L8.3365 8.64367C8.61089 8.58425 8.84767 8.41222 8.98897 8.16962L11.1359 4.48359Z" fill="currentColor"></path>
                                                        </svg></span>
                </label>
                <input class="rating-input" name="rating" value="5" onclick="setRating(5)" type="radio" id="kt_rating_input_5"/>
                </div>
<textarea maxlength="1000" class="form-control mt-3" placeholder="پیشنهاد یا نظر شما در رابطه با این تیکت" id="review" ></textarea>
@endrole
                    </div>`,
                    icon: "info",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "بستن تیکت",
                    cancelButtonText: 'انصراف',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: 'btn btn-secondary'
                    }
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        await @this.
                        set('review', $('#review').val());
                        await @this.
                        closeTicket();
                    }
                });
            });
        })


        function setRating(value) {
            @this.
            set('rating', value);
        }

        document.addEventListener('ScrollDown', function () {
            var scroll = $('#kt_scroll');
            scroll.scrollTop(parseInt(scroll.prop('scrollHeight')));
            $('#fileName').text('');
            (new Audio('{{asset('media/sounds/message_pop.mp3')}}')).play();
        })
        document.addEventListener('newTicketMessage', function () {
            toastr.info('پیام جدیدی برای شما ثبت شد');
        });

    </script>
@endpush
@section('title')
    جزییات تیکت
@endsection
@section('description')
    جزییات تیکت
@endsection
