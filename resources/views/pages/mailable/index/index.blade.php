<x-base-layout>


    @section('actions')

        <div class="d-flex align-items-center py-1">
            <!--begin::Wrapper-->
            <div>
                <a href="#" class="btn btn-sm btn-primary fw-bolder" data-bs-toggle="modal" data-bs-target="#createMailable" id="createMailableButton">
                    <span style="margin-left: 0.5rem">افزودن ایمیل جدید</span>
                    {!! theme()->getSvgIcon("icons/duotune/general/gen035.svg", "svg-icon svg-icon-1 m-0") !!}
                </a>
            </div>
            <!--end::Wrapper-->
        </div>

@endsection

    <!--begin::Card-->
    <div class="card">
        <!--begin::Card body-->
        <div class="card-body pt-6">
            @include('pages.mailable.index._table')
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->

    <livewire:mail.create-mailable />
</x-base-layout>
