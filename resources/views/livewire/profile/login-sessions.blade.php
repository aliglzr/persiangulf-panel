<div class="card pt-4 mb-6 mb-xl-9" xmlns:wire="http://www.w3.org/1999/xhtml">
@php
    use Illuminate\Support\Collection;
    /**
    * @var Collection $sessions
    */
@endphp
<!--begin::Card header-->
    <div class="card-header border-0">
        <!--begin::Card title-->
        <div class="card-title">
            <h2>{{__('messages.Sessions')}}</h2>
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Filter-->
            @if($sessions->count() > 1)
                <button wire:click="destroyAllSessions" type="button" class="btn btn-sm btn-flex btn-light-primary">
                    <?= get_svg_icon('icons/duotone/Interface/Sign-Out.svg') ?>
                    {{__('messages.Terminate all sessions')}}
                </button>
        @endif
        <!--end::Filter-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0 pb-5">
        <!--begin::Table wrapper-->
        <div class="table-responsive">
            <!--begin::Table-->
            @if($sessions->count())
                <table class="table align-middle table-row-dashed gy-5">
                    <!--begin::Table head-->
                    <thead class="border-bottom border-gray-200 fs-7 fw-bolder">
                    <!--begin::Table row-->
                    <tr class="text-start text-muted text-uppercase gs-0">
                        <th class="min-w-25px">#</th>
                        <th>{{__('messages.Device')}}</th>
                        <th>{{__('messages.Ip Address')}}</th>
                        <th class="min-w-125px">آخرین فعالیت</th>
                        <th class="min-w-70px">عملیات</th>
                    </tr>
                    <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fs-6 fw-bold text-gray-600">
                    @foreach($sessions as $key => $session)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$session->agent->browser()}} - {{$session->agent->platform()}}</td>
                            <td>{{convertNumbers($session->ip_address)}}</td>
                            <td>{{convertNumbers($session->last_activity)}}</td>
                            @if($session->is_current)
                                <td class="text-primary">{{__('messages.Current session')}}</td>
                            @else
                                <td>
                            <span wire:click="destroySession({{$session}})"
                                  class="text-danger cursor-pointer">{{__('messages.Terminate')}}</span>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
            @else
                <p class="text-center text-muted">{{__('messages.There is no available session')}}</p>
        @endif
        <!--end::Table-->
        </div>
        <!--end::Table wrapper-->
    </div>
    <!--end::Card body-->
</div>
