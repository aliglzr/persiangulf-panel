<div wire:ignore.self class="modal fade" tabindex="-1" id="renewSubscriptionModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-gray-900">
                    @if(!auth()->user()->isManager())
                        خرید اشتراک
                    @else
                    {{$client?->introducer?->id == \App\Models\User::where('username','solidvpn_sales')->first()?->id ? 'خرید اشتراک مشتری سایت' : 'خرید اشتراک مشتری نماینده'}}
                    @endif
                </h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                     aria-label="Close">
                    <span class="svg-icon svg-icon-1"></span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
            @if(!auth()->user()->isManager() &&  $planUsers->count() > 0)
                <!--begin::Notice-->
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
                                    <h4 class="text-info fs-5" style="line-height: 1.5">در صورتی که مشتری دارای اشتراک فعال باشد، خرید اشتراک در حالت رزرو قرار گرفته و امکان لغو آن وجود نخواهد داشت</h4>
                                </div>
                                <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->

                </div>
                <!--end::Notice-->
            @endif
                @if($planUsers->count())
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <div wire:ignore>
                            <!--begin::Label-->
                            <label class="fw-bold fs-6 mb-3">
                                طرح
                            </label>
                            <!--end::Label-->

                            <!--begin::Col-->
                            <select id="select_plan" aria-label="انتخاب طرح"
                                    class="form-select @error('plan_user_id') is-invalid @enderror form-select-solid form-select-lg fw-bold">
                                <option value="">انتخاب طرح</option>
                                @foreach($planUsers as $planUser)
                                    <option value="{{ $planUser->id }}">{{ convertNumbers($planUser->plan_title) }}
                                        - {{ convertNumbers($planUser->plan_duration).' روزه ' }}
                                        - {{ convertNumbers($planUser->plan_users_count).' اشتراک ' }}
                                        - {{ !is_null($planUser->plan_traffic) ? convertNumbers(formatBytes($planUser->plan_traffic)) : 'ترافیک نامحدود'  }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('plan_user_id')
                        <div class="text-danger">{{$message}}</div> @enderror
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                @else

                    <div class="d-flex flex-column justify-content-center align-items-center px-4 py-3 border-gray-200 mb-2">
                        <div class="mb-2">
                            طرح فعالی وجود ندارد، جهت تمدید مشتری طرحی را خریداری نمایید
                        </div>
                        <div>
                            <a href="http://localhost:8000/plans/buy" class="text-primary fw-bold">مشاهده طرح ها</a>
                        </div>
                        <div class="text-center px-4">
                            <img class="mw-100 mh-150px" alt="image"
                                 src="http://localhost:8000/media/illustrations/sigma-1/11.png">
                        </div>
                    </div>
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light"
                        data-bs-dismiss="modal">بستن
                </button>
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
            </div>

        </div>

    </div>
</div>

@push('scripts')
    <script>
        function setUser(id) {
            @this.setUser(id);
        }

        const renewSubscriptionModal = document.getElementById('renewSubscriptionModal')
        renewSubscriptionModal.addEventListener('hidden.bs.modal', event => {
            @this.resetModal();
            $("#select_plan").val("").trigger('change');
        });

        // function deletePlan(id){
        // @this.emit('deletePlan',id);
        // }
        //
        document.addEventListener('toggleRenewSubscriptionModal', () => {
            $('#renewSubscriptionModal').modal('toggle');
            let table = window.window.LaravelDataTables['clients-table'];
            if (table) {
                table.ajax.reload();
            }
        });

        document.addEventListener('livewire:load', function () {
            $('#select_plan').select2({
                placeholder: "انتخاب طرح",
                dropdownParent: $('#renewSubscriptionModal'),
                allowClear: true,
            }).on('change', function () {
                @this.set('plan_user_id', $(this).val());
            });
        })

        document.addEventListener('reloadSelect2',function () {
            $('#select_plan').select2({
                placeholder: "انتخاب طرح",
                dropdownParent: $('#renewSubscriptionModal'),
                allowClear: true,
            }).on('change', function () {
            @this.set('plan_user_id', $(this).val());
            });
        })

    </script>
@endpush
