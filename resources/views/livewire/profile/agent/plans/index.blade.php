<div>
    <livewire:profile.agent.navbar :user="$user" />

    <livewire:profile.agent.plans.list-plan-users :user="$user"/>

    <livewire:profile.agent.plans.consumed-plans-data-table :user="$user"/>


    <livewire:profile.agent.plans.add-subscription :user="$user"/>


</div>
@section('title')
    طرح های خریداری شده
@endsection
@section('description')
   مشخصات طرح های خریداری شده
@endsection

