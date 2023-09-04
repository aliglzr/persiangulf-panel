<div>
    <livewire:profile.agent.navbar :user="$user"/>

    <livewire:profile.login-sessions :user="$user"/>

    @if(auth()->user()->id == $user->id || auth()->user()->isManager())
        <livewire:profile.manager.security.two-factor-authentication :user="$user" />
    @endif

    <livewire:profile.email-preferences :user="$user"/>

    @if(auth()->user()->can('view-user-log'))
    <livewire:profile.logs :user="$user"/>
    @endif
</div>
@section('title')
    امنیت حساب کاربری
@endsection
@section('description')
    امنیت حساب کاربری
@endsection

