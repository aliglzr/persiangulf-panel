{{-- Page Loader Types --}}

{{-- Default --}}
@if (config('main.general.layout.loader.type') == 'default')
    <div class="page-loader bg-body">
        <div class="spinner-border"></div>
    </div>
@endif

{{-- Spinner Message --}}
@if (config('main.general.layout.loader.type') == 'spinner-message')
    <div class="page-loader page-loader-base @if(\App\Core\Adapters\Theme::isDarkMode()) bg-body @endif">
        <div class="blockui">
            <span>Please wait...</span>
            <span><div class="spinner-border text-primary"></div></span>
        </div>
    </div>
@endif

{{-- Spinner Logo --}}
@if (config('main.general.layout.loader.type') == 'spinner-logo')
    <div class="page-loader page-loader-logo @if(\App\Core\Adapters\Theme::isDarkMode()) bg-body @endif">
        <img alt="{{ config('app.name') }}" src="{{ asset('media/logos/logo-letter-1.png') }}"/>
        <div class="spinner-border text-primary"></div>
    </div>
@endif
