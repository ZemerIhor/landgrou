<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        $settings = app(\App\Settings\GlobalSettings::class);
        $locale = app()->getLocale();
    @endphp

    <title>{{ $settings->site_name[$locale] ?? __('messages.settings.default_site_name') }}</title>
    <meta name="description" content="{{ $settings->meta_description[$locale] ?? __('messages.settings.default_meta_description') }}">

    @if ($settings->favicon)
        <link rel="icon" href="{{ Storage::url($settings->favicon) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.svg') }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="flex flex-col min-h-screen antialiased text-gray-900 relative">
@livewire('components.navigation')

<main>
    {{ $slot }}
</main>

@livewireScripts
@stack('scripts')

<x-footer/>
<button
 id="scrollToTopBtn"
    type="button"
    aria-label="Scroll to top of page"
    class="flex fixed bottom-4 right-4 z-50 gap-2.5 justify-center items-center self-start px-3 w-12 h-12 bg-green-600 rounded-[32px] hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-zinc-800 transition-colors duration-200"
    onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
>
    <div class="flex self-stretch my-auto w-6 min-h-6" aria-hidden="true">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
             xmlns="http://www.w3.org/2000/svg" class="text-white">
            <path d="M7 14L12 9L17 14" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>
</button>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const scrollBtn = document.getElementById('scrollToTopBtn');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollBtn.classList.remove('hidden');
                scrollBtn.classList.add('flex');
            } else {
                scrollBtn.classList.remove('flex');
                scrollBtn.classList.add('hidden');
            }
        });
    });
</script>

</body>
</html>
