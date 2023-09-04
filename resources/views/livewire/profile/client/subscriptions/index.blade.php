<div>
    <livewire:profile.client.navbar :user="$user" />

    <livewire:profile.client.subscriptions.list-subscriptions :user="$user"/>

    <livewire:profile.client.subscriptions.subscriptions-table :user="$user"/>
</div>
@section('title')
    اشتراک های خریداری شده
@endsection
@section('description')
   مشخصات اشتراک های خریداری شده
@endsection
