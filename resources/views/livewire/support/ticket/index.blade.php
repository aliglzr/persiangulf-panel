<div>
    <livewire:support.header :user="$user"/>
    <livewire:support.ticket.tickets-data-table :user="$user"/>
    <livewire:support.submit-ticket-modal/>
</div>
@section('title')
    تیکت ها
@endsection
@section('description')
    تیکت ها
@endsection
