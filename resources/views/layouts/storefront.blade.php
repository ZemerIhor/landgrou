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
<body class="flex flex-col min-h-screen antialiased text-gray-900">
@livewire('components.navigation')

<main>
    {{ $slot }}
</main>

@livewireScripts
@stack('scripts')

<x-footer/>
</body>
</html>
