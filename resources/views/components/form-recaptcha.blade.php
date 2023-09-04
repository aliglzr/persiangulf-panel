@props(['id'])

    @push('scripts')
        <script>
            function {{ $id }}Submit(captchaToken) {
            @this.handleRecaptcha(captchaToken);
            }
        </script>
    @endpush

    <div>
        <div id="{{ $id }}"
             wire:ignore></div>

        @error('recaptcha')
        {{ $message }}
        @enderror
</div>
