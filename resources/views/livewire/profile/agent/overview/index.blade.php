<div>
    <livewire:profile.agent.navbar :user="$user" />

    <livewire:profile.agent.overview.edit :user="$user" />

    @if(auth()->user()->isManager() || auth()->user()->hasPermissionTo('deactivate-agent'))
    <livewire:profile.deactivate-account :user="$user" />
    @endif

    @if(auth()->user()->isManager() || auth()->user()->hasPermissionTo('delete-agent'))
        <livewire:profile.delete-account :user="$user" />
    @endif
    @section('title')
        جزییات حساب کاربری
    @endsection
    @section('description')
        جزییات حساب کاربری
    @endsection
</div>


