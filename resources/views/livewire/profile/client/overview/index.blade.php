<div>
    <livewire:profile.client.navbar :user="$user" />

    <livewire:profile.client.overview.edit :user="$user" />

    <livewire:profile.email-preferences :user="$user" />

    @if(auth()->user()->can('view-user-log'))
        <livewire:profile.logs :user="$user"/>
    @endif

    @if(auth()->user()->isManager() || auth()->user()->id == $user->introducer->id || auth()->user()->can('deactivate-client'))
    <livewire:profile.deactivate-account :user="$user" />
    @endif

    @if(auth()->user()->isManager() || auth()->user()->id == $user->introducer->id || auth()->user()->can('delete-client'))
        <livewire:profile.delete-account :user="$user" />
    @endif

    @section('title')
        جزییات حساب کاربری
    @endsection
    @section('description')
        جزییات حساب کاربری
    @endsection
</div>
