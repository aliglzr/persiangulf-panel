<div wire:ignore class="modal fade" tabindex="-1" id="quickAccessRenewSubscriptionModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-gray-900">خرید اشتراک</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                     aria-label="Close">
                    <span class="svg-icon svg-icon-1"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                @if(\App\Models\PlanUser::getActivePlanUsers(auth()->user())->count() > 0)
                <div class="notice d-flex flex-center bg-light-info rounded border-info border border-dashed mb-9 p-3">
                    <!--begin::Icon-->
                    <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                {!! get_svg_icon('icons/duotune/general/gen044.svg','svg-icon svg-icon-2tx svg-icon-info me-4') !!}
                <!--end::Svg Icon-->
                    <!--end::Icon-->
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-grow-1">
                        <!--begin::Content-->
                        <div class="fw-semibold">
                            <h4 class="text-info fs-5" style="line-height: 1.5">در صورتی که مشتری دارای اشتراک فعال
                                باشد، خرید اشتراک در حالت رزرو قرار گرفته و امکان لغو آن وجود نخواهد داشت</h4>
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->

                </div>
                @endif


            @if(\App\Models\PlanUser::getActivePlanUsers(auth()->user())->count())
                <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <div wire:ignore>
                            <!--begin::Label-->
                            <label class="fw-bold fs-6 mb-3">
                                مشتری
                            </label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <select id="quick_access_select_client_id" aria-label="انتخاب مشتری"
                                    class="form-select @error('client_id') is-invalid @enderror form-select-solid form-select-lg fw-bold">
                                <option value="">انتخاب مشتری</option>
                                @foreach(auth()->user()->clients() as $client)
                                    <option
                                        value="{{ $client->id }}">{{$client->username. ' - ' .$client->first_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('client_id')
                        <div class="text-danger">{{$message}}</div> @enderror
                    <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <div wire:ignore>
                            <!--begin::Label-->
                            <label class="fw-bold fs-6 mb-3">
                                طرح
                            </label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <select id="quick_access_select_plan_id" aria-label="انتخاب طرح"
                                    class="form-select @error('planUser_id') is-invalid @enderror form-select-solid form-select-lg fw-bold">
                                <option value="">انتخاب طرح</option>
                                @foreach(\App\Models\PlanUser::getActivePlanUsers(auth()->user()) as $planUser)
                                    <option value="{{ $planUser->id }}">{{ $planUser->plan_title }}
                                        - {{ $planUser->plan_duration.' روزه ' }}
                                        - {{ $planUser->plan_users_count.' اشتراک ' }}
                                        - {{ !is_null($planUser->plan_traffic) ? formatBytes($planUser->plan_traffic) : 'ترافیک نامحدود'  }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('planUser_id')
                        <div class="text-danger">{{$message}}</div> @enderror
                    <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                @else

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
                        data-bs-dismiss="modal">بستن
                </button>
                @if(\App\Models\PlanUser::getActivePlanUsers(auth()->user())->count())
                    <button type="submit" wire:click.prevent="renewSubscription()" wire:target="renewSubscription" wire:loading.attr="disabled" class="btn btn-primary">

                        <!--begin::Indicator-->
                        <span class="indicator-label" wire:target="renewSubscription" wire:loading.class="d-none">
    خرید اشتراک
</span>
                        <span class="indicator-progress" wire:target="renewSubscription" wire:loading.class="d-block">
    در حال پردازش
    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
</span>
                        <!--end::Indicator-->
                    </button>
                @endif
            </div>

        </div>

    </div>
</div>
@push('scripts')
    <script>
        const quickAccessRenewSubscriptionModal = document.getElementById('quickAccessRenewSubscriptionModal')
        quickAccessRenewSubscriptionModal.addEventListener('hidden.bs.modal', event => {
        @this.resetModal();
            $("#quick_access_select_plan_id").val("").trigger('change');
            $("#quick_access_select_client_id").val("").trigger('change');
        });

        document.addEventListener('toggleQuickAccessRenewSubscriptionModal', () => {
            $('#quickAccessRenewSubscriptionModal').modal('toggle');
            let table = window.window.LaravelDataTables['clients-table'];
            if (table) {
                table.ajax.reload();
            }
        });

        document.addEventListener('livewire:load', function () {
            $('#quick_access_select_plan_id').select2({
                placeholder: "انتخاب طرح",
                dropdownParent: $('#quickAccessRenewSubscriptionModal'),
                allowClear: true,
            }).on('change', function () {
            @this.set('planUser_id', $(this).val());
            });

            $('#quick_access_select_client_id').select2({
                placeholder: "انتخاب مشتری",
                dropdownParent: $('#quickAccessRenewSubscriptionModal'),
                allowClear: true,
            }).on('change', function () {
            @this.set('client_id', $(this).val());
            });
        });

    </script>
@endpush
