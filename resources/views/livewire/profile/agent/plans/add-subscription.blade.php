<div wire:ignore.self class="modal fade" tabindex="-1" id="addSubscriptionModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-gray-900">ثبت اشتراک جدید</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                     aria-label="Close">
                    <span class="svg-icon svg-icon-1"></span>
                </div>
                <!--end::Close-->
            </div>
            <div class="modal-body">

                @if(\App\Models\PlanUser::getActivePlanUsers($user)->count() > 0)
                <div class="{{!$clientCreated ? 'd-block' : 'd-none'}}">

                    <!--begin::Input group-->
                    <div class="row fv-row mb-7">
                        <!--begin::Col-->
                        <div class="col-xl-6 mb-8 mb-lg-0">
                            <label for="first_name"
                                   class="col-form-label fs-6 fw-bolder required">نام</label>
                            <input id="first_name" class="form-control @error('first_name') is-invalid @enderror bg-transparent" type="text" required wire:model.defer="first_name" autocomplete="off" placeholder="نام"/>
                            @error('first_name')
                            <div class="fv-plugins-message-container invalid-feedback">
                                <div data-field="first_name">{{$message}}</div>
                            </div>
                            @enderror
                        </div>
                    <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-xl-6">
                            <label for="last_name"
                                   class="col-form-label fs-6 fw-bolder">نام خانوادگی (اختیاری)</label>
                            <input id="last_name" class="form-control @error('last_name') is-invalid @enderror bg-transparent" required type="text" wire:model.defer="last_name" autocomplete="off" placeholder="نام خانوادگی"/>
                            @error('last_name')
                            <div class="fv-plugins-message-container invalid-feedback">
                                <div data-field="last_name">{{$message}}</div>
                            </div>
                            @enderror
                        </div>
                    <!--end::Col-->
                        <small class="text-primary fw-5 fw-bold mt-2"><span
                                class="fs-3 fw-bolder">توجه: </span>نام کاربری و گذرواژه به صورت خودکار ساخته و به شما
                            نمایش داده میشود</small>
                    </div>
                    <!--end::Input group-->

                    <div class="fv-row">
                        <div wire:ignore class="col-lg-4 d-flex justify-content-start align-items-baseline">
                            <label for="email"
                                   class="col-form-label fs-6 fw-bolder">ایمیل مشتری (اختیاری)</label>
                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                               title="از ایمیل مشتری جهت ارسال اطلاعیه ها استفاده میشود"></i>
                        </div>

                        <input id="email" wire:model.defer="email"
                               class="form-control @error('email') is-invalid @enderror mb-3">
                        @error('email')
                        <div class="invalid-feedback" role="alert">{{$message}}</div>
                        @enderror
                    </div>

                    <!--begin::Input group-->
                    <div class="fv-row {{$quickAccess == false ? 'd-none' : ''}}">
                        <div wire:ignore>
                            <!--begin::Label-->
                            <div wire:ignore class="col-lg-4 d-flex justify-content-start align-items-baseline">
                                <label for="select_plan"
                                       class="col-form-label fs-6 fw-bolder">انتخاب طرح</label>
                            </div>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <select id="select_plan" aria-label="انتخاب طرح"
                                    class="form-select form-select-lg fw-bold">
                                <option value="">انتخاب طرح</option>
                                @foreach(\App\Models\PlanUser::getActivePlanUsers($user) as $planUser)
                                    <option value="{{ $planUser->id }}">{{ convertNumbers($planUser->plan_title) }}
                                        - {{ convertNumbers($planUser->plan_duration).' روزه ' }}
                                        - {{ convertNumbers($planUser->plan_users_count).' اشتراک ' }}
                                        - {{ !is_null($planUser->plan_traffic) ? convertNumbers(formatBytes($planUser->plan_traffic)) : 'ترافیک نامحدود'  }}</option>
                                @endforeach
                            </select>
                        </div>
                    <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                </div>


                <div class="{{$clientCreated ? 'd-block' : 'd-none'}}">
                    <h3 class="fw-bold text-primary">اطلاعات ورود مشترک جدید را یادداشت کنید</h3>
                    <div class="fv-row">
                        <label for="username"
                               class=" col-lg-4 col-form-label fs-6 fw-bolder">نام کاربری</label>
                        <input id="username" class="form-control disabled" value="{{$username}}"
                               readonly>
                    </div>
                    <!--begin:: Password-->
                    <div class="fv-row">
                    <!--begin::Label-->
                    <label class=" col-lg-4 col-form-label fs-6 fw-bolder">گذرواژه</label>
                    <!--end::Label-->
                    <!--begin::Input wrapper-->
                    <div class="position-relative mb-3">
                        <input class="form-control"
                               wire:model.lazy="password" placeholder=""
                               autocomplete="off" readonly/>
                    </div>

                    <!--end::Input wrapper-->
                </div>

            </div>
                    @elseif(\App\Models\PlanUser::getActivePlanUsers($user)->count() <= 0 && $clientCreated)
                    <div class="{{$clientCreated ? 'd-block' : 'd-none'}}">
                        <h3 class="fw-bold text-primary">اطلاعات ورود مشترک جدید را یادداشت کنید</h3>
                        <div class="fv-row">
                            <label for="username"
                                   class=" col-lg-4 col-form-label fs-6 fw-bolder">نام کاربری</label>
                            <input id="username" class="form-control disabled" value="{{$username}}"
                                   readonly>
                        </div>
                        <!--begin:: Password-->
                        <div class="fv-row">
                            <!--begin::Label-->
                            <label class=" col-lg-4 col-form-label fs-6 fw-bolder">گذرواژه</label>
                            <!--end::Label-->
                            <!--begin::Input wrapper-->
                            <div class="position-relative mb-3">
                                <input class="form-control"
                                       wire:model.lazy="password" placeholder=""
                                       autocomplete="off" readonly/>
                            </div>

                            <!--end::Input wrapper-->
                        </div>

                    </div>
                @elseif(\App\Models\PlanUser::getActivePlanUsers($user)->count() <= 0 && !$clientCreated)
                    <div
                        class="d-flex flex-column justify-content-center align-items-center px-4 py-3 border-gray-200 mb-2">
                        <div class="mb-2">
                            طرح فعالی وجود ندارد، جهت تمدید مشتری طرحی را خریداری نمایید
                        </div>
                        <div>
                            <a href="{{route('plans.buy')}}" class="text-primary fw-bold">مشاهده طرح ها</a>
                        </div>
                        <div class="text-center px-4">
                            <img class="mw-100 mh-150px" alt="image"
                                 src="{{asset('media/illustrations/sigma-1/11.png')}}">
                        </div>
                    </div>
                @endif

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light"
                    data-bs-dismiss="modal">{{!$clientCreated ? 'انصراف' : 'بستن'}}</button>
            @if(!$clientCreated)
                <button wire:target="createSubscription" wire:loading.attr="disabled" type="submit" wire:click.prevent="createSubscription()" class="btn btn-primary">

                    <!--begin::Indicator-->
                    <span class="indicator-label" wire:target="createSubscription" wire:loading.class="d-none">
    ایجاد اشتراک
</span>
                    <span class="indicator-progress" wire:target="createSubscription" wire:loading.class="d-block">
    در حال پردازش
    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
</span>
                    <!--end::Indicator-->
                </button>
            @endif
        </div>

    </div>

</div>


@push('scripts')
    <script>
        const addSubscriptionModal = document.getElementById('addSubscriptionModal')
        addSubscriptionModal.addEventListener('hidden.bs.modal', event => {
        @this.resetModal();
            $("#select_plan").val("").trigger('change');
        });

        // function deletePlan(id){
        // @this.emit('deletePlan',id);
        // }
        //
        document.addEventListener('toggleAddSubscriptionModal', () => {
            $('#addSubscriptionModal').modal('toggle');
            let table = window.window.LaravelDataTables['plans-table'];
            if (table) {
                table.ajax.reload();
            }
        });

        document.addEventListener('livewire:load',function () {
            $('#select_plan').select2({
                placeholder: "انتخاب طرح",
                dropdownParent: $('#addSubscriptionModal'),
                allowClear: true,
            }).on('change', function () {
            @this.set('plan_user_id', $(this).val());
            });
        })
    </script>
@endpush
