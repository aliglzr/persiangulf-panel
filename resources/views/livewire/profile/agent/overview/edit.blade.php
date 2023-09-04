<div>
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">مشخصات</h3>
            </div>
            <!--end::Card title-->
        </div>
        <div id="kt_account_profile_details" class="collapse show">
            <!--begin::Form-->
            <form class="form">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">نام و نام خانوادگی</label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" wire:model.lazy="user.first_name"
                                           class="form-control @error('user.first_name') is-invalid @enderror form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="نام"/>
                                    @error('user.first_name')
                                    <div class="invalid-feedback">{{$message}}</div> @enderror
                                </div>
                                <!--end::Col-->

                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" wire:model.lazy="user.last_name"
                                           class="form-control @error('user.last_name') is-invalid @enderror  form-control-lg form-control-solid"
                                           placeholder="نام خانوادگی"/>
                                    @error('user.last_name')
                                    <div class="invalid-feedback" role="alert">{{$message}}</div> @enderror
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">نام کاربری</label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            @if(auth()->user()->getRole() == 'manager')
                                <input type="text" wire:model.lazy="user.username"
                                       class="form-control @error('user.username') is-invalid @enderror form-control-lg form-control-solid"/>
                            @else
                                <input type="text" value="{{$user->username}}"
                                       class="form-control @error('user.username') is-invalid @enderror form-control-lg form-control-solid" readonly/>
                            @endif
                            @error('user.username')
                            <div class="invalid-feedback">{{$message}}</div> @enderror
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-bold fs-6">
                            <span class="required">آدرس ایمیل</span>
                            @if(!auth()->user()->isManager())
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                   title="جهت تغییر ایمیل، ابتدا باید ایمیل خود را تایید کنید"></i>
                            @endif
                        </label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="email" wire:model.lazy="email"
                                   class="form-control @error('email') is-invalid @enderror form-control-lg form-control-solid" placeholder="ایمیل"/>
                            @error('email')
                            <div class="invalid-feedback">{{$message}}</div> @enderror
                            @if($user->getData('temp_mail'))
                                <div class="fs-5 fw-semibold text-warning mt-2">درخواست شما برای تغییر ایمیل ثبت شده است، لطفا جهت تغییر ایمیل، لینک تایید ارسال شده به ایمیل فعلی خود را باز کنید</div>
                            @endif
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->


                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class=" col-lg-4 col-form-label fs-6 fw-bolder">{{__('messages.Password')}}</label>
                        <!--end::Label-->

                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row" data-kt-password-meter="true" wire:ignore.self>
                            <!--begin::Input wrapper-->
                            <div class="position-relative mb-3" wire:ignore.self>
                                <input class="form-control form-control-lg form-control-solid"
                                       type="password" wire:model.defer="password" placeholder=""
                                       autocomplete="off"/>
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                      data-kt-password-meter-control="visibility" wire:ignore.self>
																	<i class="bi bi-eye-slash fs-2"></i>
																	<i class="bi bi-eye fs-2 d-none"></i>
																</span>
                            </div>
                            <!--end::Input wrapper-->
                            <!--begin::Meter-->
                            <div class="d-flex align-items-center mb-3"
                                 data-kt-password-meter-control="highlight" wire:ignore>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                            </div>
                            <!--begin::Hint-->
                            @error('password')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-text">تنها در صورت تغییر رمز عبور، فیلد گذرواژه را تکمیل کنید</div>
                            <!--end::Hint-->
                            <!--end::Meter-->
                        </div>

                        <!--end::Col-->
                    </div>

                    <!--end::Input group-->
                    <div class="row mb-6">
                        <label for="password" class="col-lg-4 col-form-label fs-6 fw-bolder">{{__('messages.Password Confirmation')}}</label>
                        <div class="col-lg-8 fv-row mb-0">
                            <input autocomplete="new-password" type="password" placeholder="{{__('messages.Password Confirmation')}}" class="form-control @error('password_confirmation') is-invalid @enderror form-control-lg form-control-solid" wire:model.defer="password_confirmation" id="password_confirmation">
                            @error('password_confirmation')
                            <div class="invalid-feedback" role="alert">{{$message}}</div>
                            @enderror
                        </div>
                    </div>


                    <!--begin::Input group-->
                    @if(auth()->user()->isManager())
                        <div class="row mb-6">
                            <label for="user.reference_id" class=" col-lg-4 col-form-label fs-6 fw-bolder">معرف</label>
                            <div class="col-lg-8 fv-row mb-0">
                                <div wire:ignore>
                                    <select onchange="onReferenceChange()" id="reference_id" class="form-select form-control @error('user.reference_id') is-invalid @enderror form-control-lg form-control-solid" data-control="select2" data-placeholder="Select an option">
                                        <option value="null">بدون معرف</option>
                                        @foreach(\App\Models\User::role('agent')->get() as $introducer)
                                            <option value="{{$introducer->id}}" {{ $user->introducer?->id == $introducer->id ? 'selected' : '' }}>{{$introducer->full_name . ' - @' . $introducer->username}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('user.reference_id')
                                <div class="invalid-feedback" role="alert">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                @endif
                <!--begin::Input group-->


                </div>
                <!--end::Card body-->

                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">

                    <button wire:click.prevent="edit()" wire:target="edit" wire:loading.attr="disabled" class="btn btn-primary" id="kt_account_profile_details_submit">
               <span class="indicator-label" wire:target="edit" wire:loading.class="d-none" >
 ثبت
               </span>
                        <span class="indicator-progress" wire:target="edit" wire:loading.class="d-block">
                        در حال ثبت
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
</span>
                    </button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
    </div>
    @if(auth()->user()->isManager())
        @push('scripts')
            <script>
                function onReferenceChange() {
                @this.set('user.reference_id', $('#reference_id').val());
                }
            </script>
        @endpush
    @endif
</div>
