<?php

return [

    'label' => 'Податкова зона',

    'plural_label' => 'Податкові зони',

    'table' => [
        'name' => [
            'label' => 'Назва',
        ],
        'zone_type' => [
            'label' => 'Тип зони',
        ],
        'active' => [
            'label' => 'Активна',
        ],
        'default' => [
            'label' => 'За замовчуванням',
        ],
    ],

    'form' => [
        'name' => [
            'label' => 'Назва',
        ],
        'zone_type' => [
            'label' => 'Тип зони',
            'options' => [
                'country' => 'Обмежити країнами',
                'states' => 'Обмежити областями/штатами',
                'postcodes' => 'Обмежити поштовими індексами',
            ],
        ],
        'price_display' => [
            'label' => 'Відображення цін',
            'options' => [
                'include_tax' => 'З податком',
                'exclude_tax' => 'Без податку',
            ],
        ],
        'active' => [
            'label' => 'Активна',
        ],
        'default' => [
            'label' => 'За замовчуванням',
        ],

        'zone_countries' => [
            'label' => 'Країни',
        ],

        'zone_country' => [
            'label' => 'Країна',
        ],

        'zone_states' => [
            'label' => 'Області/Штати',
        ],

        'zone_postcodes' => [
            'label' => 'Поштові індекси',
            'helper' => 'Вказуйте кожен індекс з нового рядка. Підтримуються шаблони, наприклад NW*',
        ],

    ],

];
