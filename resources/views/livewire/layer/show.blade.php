<div class="d-flex flex-column flex-lg-row">
    <!--begin::Sidebar-->
    <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
        <!--begin::Card-->
        <div class="card mb-5 mb-xl-8">
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Summary-->
                <!--begin::User Info-->
                <div class="d-flex flex-center flex-column py-5">
                            <!--begin::Avatar-->
                    <div class="symbol symbol-100px symbol-circle mb-7">
                        <i class="bi bi-layers {{$layer->active ? 'text-success' : 'text-danger'}} fs-1"></i>
                    </div>
                    <!--end::Avatar-->
                    <!--begin::Name-->
                    <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{$layer->name}}</a>
                    <!--end::Name-->
                    <!--begin::Position-->
                    <div class="mb-9">
                        <!--begin::Badge-->
                        <div class="badge badge-lg badge-light-primary d-inline">{{$layer->active ? 'فعال' : 'غیر فعال'}}</div>
                        <!--begin::Badge-->
                    </div>
                    <!--end::Position-->
                    <!--begin::Info-->
                    <!--begin::Info heading-->
                    <div class="fw-bold mb-3">جزییات</div>
                    <!--end::Info heading-->

                    <div>
                        <div class="d-flex flex-wrap flex-center">
                            <!--begin::Stats-->
                            <div class="d-flex flex-column flex-center border border-gray-300 border-dashed rounded py-3 px-3 mb-3 w-75px">
                                <div class="fs-4 fw-bold text-gray-700">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                    <i class="fa fa-person text-primary fs-3"></i>
{{--                                    {!! get_svg_icon('icons/duotune/arrows/arr066.svg','svg-icon svg-icon-3 svg-icon-success') !!}--}}
                                    <!--end::Svg Icon-->
                                </div>
                                <div class="fw-semibold text-primary">{{convertNumbers($layer->users()->count())}} مشتری </div>
                            </div>
                            <!--end::Stats-->
                            <!--begin::Stats-->
                            <div class="d-flex flex-column flex-center border border-gray-300 border-dashed rounded py-3 px-3 mx-4 mb-3 w-75px">
                                <div class="fs-4 fw-bold text-gray-700">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr065.svg-->
                                    <i class="fa fa-server text-primary fs-3"></i>
{{--                                    {!! get_svg_icon('icons/duotune/arrows/arr065.svg','svg-icon svg-icon-3 svg-icon-danger') !!}--}}
                                    <!--end::Svg Icon-->
                                </div>
                                <div class="fw-semibold text-primary">{{convertNumbers($layer->servers()->count())}} سرور </div>
                            </div>
                            <!--end::Stats-->
                        </div>
                    </div>

                    <!--end::Info-->
                </div>
                <!--end::User Info-->
                <!--end::Summary-->
                <!--begin::Details toggle-->
                <div class="d-flex flex-stack fs-4 py-3">
                    <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details">جزییات
                        <span class="ms-2 rotate-180">
													<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
													{!! get_svg_icon('icons/duotune/arrows/arr072.svg','svg-icon svg-icon-3') !!}
                            <!--end::Svg Icon-->
												</span></div>
                    @can('modify-server')
                        <span data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-original-title="ویرایش لایه">
													<button onclick="editLayer({{$layer->id}})" class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_update_details">ویرایش</button>
												</span>
                    @endcan
                </div>
                <!--end::Details toggle-->
                <div class="separator"></div>
                <!--begin::Details content-->
                <div wire:ignore.self id="kt_user_view_details" class="collapse show">
                    <livewire:layer.sidebar-details :layer="$layer" />
                </div>
                <!--end::Details content-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Sidebar-->
    <!--begin::Content-->
    <div class="flex-lg-row-fluid ms-lg-15">
        <!--begin:::Tab content-->
        <div class="tab-content" id="myTabContent">
            <!--begin:::Tab pane-->
            <div id="kt_user_view_overview_tab">
                <!--begin::Layer Servers table-->
                <livewire:layer.servers-table :layer="$layer" />
                <!--end::Layer Servers table-->
                <!--begin::Layer Clients table-->
                <livewire:layer.clients-table :layer="$layer" />
                <!--end::Layer Clients table-->
            </div>
            <!--end:::Tab pane-->
        </div>
        <!--end:::Tab content-->
    </div>
    <!--end::Content-->
    @can('modify-server')
        <livewire:layer.create />
    @endcan

    @if(auth()->user()->can('change-server-layer') || auth()->user()->can('change-client-layer'))
        <livewire:layer.change-layer-modal/>
    @endif

</div>
@section('title')
    جزییات لایه
@endsection
@section('description')
    جزییات لایه
@endsection

