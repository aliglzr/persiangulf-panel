<div>
    <div wire:ignore class="modal fade" id="checkLostTransaction">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">بررسی تراکنش</h5>
                </div>
                <div class="modal-body">
                    <form class="form" wire:submit.prevent="checkLostTransaction()">
                        @csrf
                        <div class="form-group">
                            <label for="password"
                                   class="col-form-label fs-6 fw-bolder">شناسه تراکنش</label>
                            <div class="input-group mb-5">
                                <input wire:model.lazy="transaction_id" type="text" class="form-control" placeholder="شناسه تراکنش" aria-label="شناسه تراکنش"
                                       aria-describedby="basic-addon1"/>
                                <span class="input-group-text" id="basic-addon1">
                                	<!--begin::Svg Icon | path: icons/duotune/general/gen061.svg-->
				            {!! get_svg_icon('icons/duotune/finance/fin010.svg','svg-icon svg-icon-3') !!}
                                <!--end::Svg Icon-->
                            </span>
                            </div>
                            {{--                        <span class="form-text text-primary font-size-h6 mt-3">صفر تومان</span>--}}
                        </div>
                        <div class="modal-footer d-flex justify-content-center align-items-center flex-row-reverse"
                             style="border-top-width: 0 !important;">
                            <button type="submit" class="btn btn-primary font-weight-bold">بررسی</button>
                            <button type="button" class="btn btn-secondary font-weight-bold" data-bs-dismiss="modal"
                                    aria-label="Close">انصراف
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
