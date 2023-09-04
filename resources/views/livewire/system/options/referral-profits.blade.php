<div class="card mb-5 mb-xl-10">
    <!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bold m-0">تعیین درصد سود نمایندگان</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->
    <!--begin::Content-->
    <div class="collapse show">
        <!--begin::Form-->
        <form class="form fv-plugins-bootstrap5 fv-plugins-framework">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                @foreach($profits as $key => $item)
                    <label class="mb-2" for="profits.{{$key}}.percent">سود سطح {{$key + 1}}</label>
                    <div class="input-group mb-4">
                        <!--begin::Input-->
                        <input type="text" wire:model.lazy="profits.{{$key}}.percent"
                               class="form-control text-left"
                               id="profits.{{$key}}.percent" placeholder="درصد سود" dir="rtl" autocomplete="off">
                        <!--end::Input-->
                        <!--begin::Button-->
                        <button class="btn btn-danger" wire:click.prevent="del({{$key}})"><i class="fa fa-close"></i>
                        </button>
                        <!--end::Button-->
                    </div>
                    @error('profits.'.$key.'.percent')
                    <div class="text-danger mt-3" role="alert">
                        {{convertNumbers($message)}}
                    </div>
                    @enderror

                @endforeach
                <button class="btn btn-primary my-2" wire:click.prevent="add"><i class="fa fa-plus"></i></button>
                <br>
                <small class="text-muted">جهت افزودن سطح سود، کلیک کنید!</small>
            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button class="btn btn-primary" wire:click.prevent="save()">ذخیره</button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Content-->
</div>
