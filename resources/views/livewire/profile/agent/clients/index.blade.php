<div>
    <livewire:profile.agent.navbar :user="$user"/>

    <livewire:profile.agent.clients.clients-table :user="$user"/>
</div>
@section('title')
    لیست مشتریان
@endsection
@section('description')
    لیست مشتریان
@endsection

