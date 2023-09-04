<tr class="odd">
        <td>{{convertNumbers($cart->plan->title)}}</td>
        <td>{{convertNumbers($cart->plan->users_count)}} اشتراک </td>
        <td>{{convertNumbers($cart->plan->duration)}} روزه </td>
        <td>@if(is_null($cart->plan->traffic))
                ترافیک نامحدود
            @else
                {{convertNumbers(formatBytes($cart->plan->traffic))}}
            @endif</td>
        <td>{{convertNumbers(number_format($cart->plan->price))}} {!! get_svg_icon('svg/coins/toman.svg','svg-icon svg-icon-3 text-dark ms-1') !!} </td>
        <td class="text-end">
            <!--begin::Delete-->
            <button wire:click.prevent="removeFromCart()"
               class="btn btn-icon btn-flex btn-active-light-primary w-30px h-30px me-3">
                <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                {!! get_svg_icon('icons/duotune/general/gen027.svg','svg-icon svg-icon-3') !!}
                <!--end::Svg Icon-->
            </button>
            <!--end::Delete-->
        </td>
    </tr>

