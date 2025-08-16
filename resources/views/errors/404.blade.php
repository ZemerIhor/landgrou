@extends('layouts.storefront')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-gray-400 mb-4">404</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Сторінка не знайдена</h2>
        <p class="text-gray-600 mb-8">Вибачте, але сторінка, яку ви шукаєте, не існує.</p>
        <a href="{{ route('home', ['locale' => app()->getLocale()]) }}"
           class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
            Повернутися на головну
        </a>
    </div>
</div>
@endsection
