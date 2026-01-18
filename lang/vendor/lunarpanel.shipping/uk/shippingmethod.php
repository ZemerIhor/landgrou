<?php

return [
    'label_plural' => 'Способи доставки',
    'label' => 'Спосіб доставки',
    'form' => [
        'name' => [
            'label' => 'Назва',
        ],
        'description' => [
            'label' => 'Опис',
        ],
        'code' => [
            'label' => 'Код',
        ],
        'cutoff' => [
            'label' => 'Час відсічки',
        ],
        'charge_by' => [
            'label' => 'Розрахунок за',
            'options' => [
                'cart_total' => 'Сума кошика',
                'weight' => 'Вага',
            ],
        ],
        'driver' => [
            'label' => 'Тип',
            'options' => [
                'ship-by' => 'Стандартний',
                'collection' => 'Самовивіз',
            ],
        ],
        'stock_available' => [
            'label' => 'Усі товари в кошику мають бути в наявності',
        ],
    ],
    'table' => [
        'name' => [
            'label' => 'Назва',
        ],
        'code' => [
            'label' => 'Код',
        ],
        'driver' => [
            'label' => 'Тип',
            'options' => [
                'ship-by' => 'Стандартний',
                'collection' => 'Самовивіз',
            ],
        ],
    ],
    'pages' => [
        'availability' => [
            'label' => 'Доступність',
            'customer_groups' => 'Цей спосіб доставки наразі недоступний для всіх груп клієнтів.',
        ],
    ],
];
