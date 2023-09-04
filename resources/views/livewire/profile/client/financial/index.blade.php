<div>

    <livewire:profile.client.navbar :user="$user"/>

    <livewire:profile.client.financial.payments-table :user="$user" />

    <livewire:profile.client.financial.invoices-table :user="$user" />

    <livewire:profile.client.financial.transactions-table :user="$user" />

</div>
@section('title')
    مالی
@endsection
@section('description')
    مالی
@endsection
