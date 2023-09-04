<div class="card mb-12">
    <!--begin::Hero body-->
    <div class="card-body flex-column p-5">
        <!--begin::Hero nav-->
        <div class="card-rounded bg-light d-flex flex-stack flex-wrap p-5">
            <!--begin::Nav-->
            <ul class="nav flex-wrap border-transparent fw-bold">
                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase {{request()->segment('2') == '' ? 'active' : ''}}"
                       href="{{route('support.index')}}">پشتیبانی</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase {{ request()->segment('2') == 'tickets' ? 'active' : ''  }}"
                       href="{{route('support.tickets',$user)}}">تیکت ها</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase {{ request()->segment('2') == 'faq' ? 'active' : ''  }}"
                       href="{{route('support.faq')}}">سوالات متداول</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item my-1">
                    <a class="btn btn-color-gray-600 btn-active-secondary btn-active-color-primary fw-bolder fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase"
                       href="{{route('support.tutorials')}}" target="_blank">آموزش</a>
                </li>
                <!--end::Nav item-->
            </ul>
            <!--end::Nav-->
            @if(request()->routeIs('support.faq'))
            @role('manager')
                <!--begin::Action-->
                <div class="d-flex">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#submit_question_modal"
                       class="btn btn-primary fw-bold fs-8 fs-lg-base">ثبت سوال</a>
                </div>
                <!--end::Action-->
            @endrole
            @endif
            @role(['agent','client'])
            <div class="d-flex">
                <a href="#" data-bs-toggle="modal" data-bs-target="#submit_ticket_modal"
                   class="btn btn-primary fw-bold fs-8 fs-lg-base mx-2">ثبت تیکت</a>
            </div>
            @endrole
        </div>
        <!--end::Hero nav-->
    </div>
    <!--end::Hero body-->
</div>
