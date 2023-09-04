<div id="{{$notice->id}}" class="notice d-flex flex-column flex-md-row bg-light-{{ $notice->color }} rounded border-{{ $notice->color }} border border-dashed {{ $notice->class }} {{ $notice->padding }} {{$read ? 'd-none' : ''}}">
@if ($notice->icon)
    <!--begin::Icon-->
    {!! theme()->getSvgIcon($notice->icon, "svg-icon-2tx svg-icon-" . $notice->color . " me-4 text-center text-md-right") !!}
    <!--end::Icon-->
@endif

<!--begin::Wrapper-->
    <div class="position-relative d-flex flex-stack flex-grow-1 {{ util()->putIf($notice->button, 'flex-wrap flex-md-nowrap') }}">
    @if ($notice->title || $notice->body)
        <!--begin::Content-->
            <div class="{{ util()->putIf($notice->button, 'mb-3 mb-md-0') }} fw-bold">
                @if ($notice->title)
                    <h4 class="text-{{$notice->color}} fw-bolder">{{ $notice->title }}</h4>
                @endif

                @if ($notice->body)
                    <div class="fs-6 text-{{$notice->color}} @if ($notice->button) {{ 'pe-7' }} @endif">{!! $notice->body !!}</div>
                @endif
            </div>
            <!--end::Content-->
    @endif

    @if ($notice->button)
        <!--begin::Action-->
                <a href="{{ $notice->button_url }}" class="btn btn-{{ $notice->color }} px-6 align-self-center text-nowrap" {{ util()->putIf($notice->button_modal_id, 'data-bs-toggle=modal data-bs-target='.$notice->button_modal_id) }}>
                    {{ $notice->button_label }}
                </a>
                <button wire:click.prevent="readNotice()" wire:target="readNotice" wire:loading.attr="disabled" class="btn btn-light-{{ $notice->color }} rounded border-{{ $notice->color }} border border-dashed bo px-6 align-self-center text-nowrap ms-2 d-block d-md-none">
                    متوجه شدم
                </button>
            <!--end::Action-->

                <button wire:click.prevent="readNotice()" wire:target="readNotice" wire:loading.attr="disabled" class="btn btn-light-{{ $notice->color }} rounded border-{{ $notice->color }} border border-dashed px-6 align-self-center text-nowrap ms-2 d-none d-md-block">
                    متوجه شدم
                </button>
@endif
    </div>
    @if(!$notice->button)
        <button wire:click.prevent="readNotice()" wire:target="readNotice" wire:loading.attr="disabled" class="btn btn-light-{{ $notice->color }} rounded border-{{ $notice->color }} border border-dashed px-6 align-self-center text-nowrap ms-2 mt-2 mt-md-0">
            متوجه شدم
        </button>
        @endif
<!--end::Wrapper-->
</div>
