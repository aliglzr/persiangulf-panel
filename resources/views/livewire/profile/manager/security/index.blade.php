<div>

    <livewire:profile.manager.navbar :user="$user"/>

    <livewire:profile.login-sessions :user="$user" />

    @if(auth()->user()->id == $user->id)
    <livewire:profile.manager.security.two-factor-authentication :user="$user" />
    @endif

    <livewire:profile.logs :user="$user" />

</div>
@section('title')
    امنیت حساب کاربری
@endsection
@section('description')
    امنیت حساب کاربری
@endsection
