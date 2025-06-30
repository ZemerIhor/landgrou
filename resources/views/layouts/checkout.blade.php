<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>Demo Storefront</title>
    <meta
        name="description"
        content="Example of an ecommerce storefront built with Lunar."
    >
    =
    @vite('resources/css/app.css')
    <link
        rel="icon"
        href="{{ asset('favicon.svg') }}"
    >
    @livewireStyles
</head>

<body class="antialiased text-gray-900">
@livewire('components.navigation')
<a href="{{ route('lang.switch', ['lang' => 'en']) }}">English</a>
<a href="{{ route('lang.switch', ['lang' => 'uk']) }}">Українська</a>


<main>
    {{ $slot }}
</main>

<x-footer/>

@livewireScripts
</body>

</html>
