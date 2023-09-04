<div>

    <livewire:profile.agent.navbar :user="$user"/>

    <livewire:profile.agent.financial.payments-table :user="$user" />

    <livewire:profile.agent.financial.invoices-table :user="$user" />

    <livewire:profile.agent.financial.transactions-table :user="$user" />
</div>
@section('title')
    مدیریت مالی
@endsection
@section('description')
    مالی
@endsection
