@if(auth()->user()->isAgent())
    @if(is_null($user->getReservedSubscription()))
        @if($user->hasActiveSubscription())
            <td class="text-end">
                <button onclick="setUser({{$user->id}})" class="btn btn-sm btn-light-primary mx-1">رزرو اشتراک</button>
            </td>
        @else
            <td class="text-end">
                <button onclick="setUser({{$user->id}})" class="btn  btn-sm btn-secondary mx-1">خرید اشتراک</button>
            </td>
        @endif
    @else
        <td class="text-end">
            <button class="btn btn-sm btn-light-success border border-dashed border-success mx-1 disabled" title="{{$user->getReservedSubscription()->planUser->plan_title}}">دارای اشتراک رزرو</button>
        </td>
    @endif
    @endif
@can('change-client-layer')
    <td class="text-end">
    <button class="btn btn-sm btn-info mx-1 w-auto" onclick="setModel({{$user->id}},'client')">{{$user->layer->name}}</button>
    </td>
@endcan
