<?php

return [
    'translatable' => true,
    'api_enabled' => true,
    'cache' => [
        'enabled' => true,
        'key' => 'filament-menu-builder',
        'ttl' => 60 * 60 * 24,
    ],
    'translatable_locales' => ['uk', 'en'],
    'usable_parameters' => [
        // For example:
        // 'mega_menu',
        // 'mega_menu_columns',
    ],
    'exclude_route_names' => [
        '/^debugbar\./',
        '/^filament\./',
        '/^livewire\./',
    ],
    'exclude_routes' => [
        //
    ],
    'dto' => [
        'menu' => \Biostate\FilamentMenuBuilder\DTO\Menu::class,
        'menu_item' => \Biostate\FilamentMenuBuilder\DTO\MenuItem::class,
    ],
    'models' => [], // Убираем все модели, чтобы отключить выбор
];
