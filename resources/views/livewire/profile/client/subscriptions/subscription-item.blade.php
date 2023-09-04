<div class="col-lg-6 mb-3">
    @php
        /** @var \App\Models\Subscription $subscription */
        $color = $reserved ? 'success' : 'primary';
    @endphp
    <div class="p-5 border-dashed rounded-2 {{$reserved ? 'border-success' : 'border-gray-200'}} ">
        <!--begin::Heading-->
        <div class="d-flex justify-content-between align-items-baseline">
            <h3 class="mb-2 h2">{{$subscription->planUser->plan_title}} {!! $reserved ? "<span class='text-success'>(در حالت رزرو)</span>" : '' !!}</h3>
        </div>

        <!--begin::Heading-->
        <div class="d-flex text-muted fw-bold fs-5 mb-3 mt-3">
            @if($reserved)
                <span class="flex-grow-1 text-gray-800">ترافیک اشتراک</span>
                <span class="text-gray-800">{{convertNumbers(formatBytes($user->getReservedSubscription()->total_traffic))}}</span>
            @else
                <span class="flex-grow-1 text-gray-800">باقیمانده ترافیک</span>
                <span class="text-gray-800">{{convertNumbers(formatBytes($subscription->remaining_traffic))}}</span>
                @endif
        </div>
        <!--end::Heading-->
        <!--begin::Progress-->
        <div class="progress h-8px bg-light-{{$color}} mb-2">
            <div class="progress-bar bg-{{$color}}" role="progressbar" style="width: {{$reserved ? 100 : $this->remainingPercent}}%" aria-valuenow="{{$reserved ? 100 : $this->remainingPercent}}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <!--end::Progress-->

        <!--begin::Info-->
        <div class="fs-5 mb-2">
            <span class="text-gray-800 fw-bold me-1"><i class="fa fa-clock"></i></span>
            @if($reserved)
                <span class="flex-grow-1 text-gray-600">مدت اشتراک: </span>
                <span class="text-gray-600 fw-semibold">{{convertNumbers($user->getReservedSubscription()->duration)}} روز </span>
            @else
                <span class="flex-grow-1 text-gray-600">تاریخ پایان اشتراک: </span>
                <span class="text-gray-600 fw-semibold">{{\App\Core\Extensions\Verta\Verta::instance($subscription->ends_at)->persianFormat('j F Y در H:i')}}</span>
            @endif
            <span class="text-gray-800 fw-bold ms-2"><i class="fa fa-cloud-arrow-down"></i></span>
            <span class="flex-grow-1 text-gray-600">حجم اشتراک: </span>
            <span class="text-gray-600 fw-semibold">
                      @if(is_null($subscription->total_traffic))
                    نامحدود
                @else
                    {{convertNumbers(formatBytes($subscription->total_traffic))}}
                @endif
            </span>
        </div>
        <!--end::Info-->
        <!--begin::Notice-->
        @if($reserved)
            <div class="d-flex justify-content-start pb-0 px-0">
                <span class="text-success fs-4">اشتراک به صورت خودکار پس از اتمام اشتراک قبلی، فعال خواهد شد</span>
            </div>
            @endif
        <!--end::Notice-->
        @if(auth()->user()->isManager())
            <button wire:click="$emit('editSubscription',{{$subscription->id}})" class="btn btn-sm btn-outline btn-outline-dashed btn-outline-primary ms-3 mt-2 btn-active-light-primary">ویرایش اشتراک</button>
        @endif
    </div>
    @if($reserved)
        @push('scripts')
            <script>
                var activeReservedSubscription = null;
                document.addEventListener('livewire:load',function () {
                    activeReservedSubscription = function () {
                        Swal.fire({
                            html : `<div class="d-flex flex-column flex-center">
                    @if(auth()->user()->hasActiveSubscription())
                            <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                   <div class="d-flex flex-stack flex-grow-1">
                       <div class="fw-semibold">
                           <h1 class="text-gray-900 fw-bold">توجه</h1>
                           <div class="fs-6 text-dark">شما در حال حاضر اشتراک فعالی دارید، در صورت فعال سازی اشتراک رزرو، اشتراک فعلی حذف و این اشتراک فعال خواهد شد</div>
               </div>
           </div>
        </div>
@endif
                            </div>
                        <h3>آیا از فعال سازی اشتراک رزرو مطمئن هستید؟</h3>

                        </div>`,
                            showCancelButton: true,
                            confirmButtonText: 'بله',
                            cancelButtonText: `خیر`,
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-secondary",
                            }
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                            @this.activeReservedSubscription();
                            }
                        })
                    }
                })


                document.addEventListener('have-reserved-subscription', function (data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطا',
                        text: 'مشتری گرامی، امکان خرید اشتراک در صورت داشتن اشتراک به صورت رزرو وجود ندارد',
                        showConfirmButton : false,
                        showCancelButton: true,
                        cancelButtonText: `متوجه شدم`,
                        customClass: {
                            cancelButton: "btn btn-secondary",
                        }
                    });
                });



            </script>
            @endpush
        @endif
</div>
