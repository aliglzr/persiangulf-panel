<div>
    @if($notices->count() > 0)
        @foreach($notices as $notice)
            <livewire:layout.notice :key="$notice->id" :notice="$notice" />
        @endforeach
        @endif
</div>
