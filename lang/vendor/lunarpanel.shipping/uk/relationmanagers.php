<?php

return [
    'shipping_methods' => [
        'customer_groups' => [
            'description' => 'Прив’яжіть групи клієнтів до цього способу доставки, щоб визначити його доступність.',
        ],
    ],
    'shipping_rates' => [
        'title_plural' => 'Тарифи доставки',
        'actions' => [
            'create' => [
                'label' => 'Створити тариф доставки',
            ],
        ],
        'notices' => [
            'prices_incl_tax' => 'Усі ціни включають податок, який буде враховано під час розрахунку мінімальної суми.',
            'prices_excl_tax' => 'Усі ціни без податку, мінімальна сума розраховується за підсумком кошика.',
        ],
        'form' => [
            'shipping_method_id' => [
                'label' => 'Спосіб доставки',
            ],
            'price' => [
                'label' => 'Ціна',
            ],
            'prices' => [
                'label' => 'Рівні цін',
                'repeater' => [
                    'customer_group_id' => [
                        'label' => 'Група клієнтів',
                        'placeholder' => 'Будь-яка',
                    ],
                    'currency_id' => [
                        'label' => 'Валюта',
                    ],
                    'min_spend' => [
                        'label' => 'Мін. сума',
                    ],
                    'min_weight' => [
                        'label' => 'Мін. вага',
                    ],
                    'price' => [
                        'label' => 'Ціна',
                    ],
                ],
            ],
        ],
        'table' => [
            'enabled' => [
                'label' => 'Увімкнено',
            ],
            'disabled' => [
                'label' => 'вимкнено',
            ],
            'shipping_method' => [
                'label' => 'Спосіб доставки',
                'disabled' => 'Вимкнено',
            ],
            'price' => [
                'label' => 'Ціна',
            ],
            'price_breaks_count' => [
                'label' => 'Рівні цін',
            ],
        ],
    ],
    'exclusions' => [
        'title_plural' => 'Виключення доставки',
        'form' => [
            'purchasable' => [
                'label' => 'Товар',
            ],
        ],
        'actions' => [
            'create' => [
                'label' => 'Додати список виключень доставки',
            ],
            'attach' => [
                'label' => 'Додати список виключень',
            ],
            'detach' => [
                'label' => 'Видалити',
            ],
        ],
    ],
];
