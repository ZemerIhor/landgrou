<?php

return [
    'label' => 'Варіант товару',
    'plural_label' => 'Варіанти товару',
    'pages' => [
        'edit' => [
            'title' => 'Основна інформація',
        ],
        'media' => [
            'title' => 'Медіа',
            'form' => [
                'no_selection' => [
                    'label' => 'Ви ще не вибрали зображення для цього варіанта.',
                ],
                'no_media_available' => [
                    'label' => 'Наразі для цього товару немає доступних медіа.',
                ],
                'images' => [
                    'label' => 'Основне зображення',
                    'helper_text' => 'Виберіть зображення товару, яке представляє цей варіант.',
                ],
            ],
        ],
        'identifiers' => [
            'title' => 'Ідентифікатори',
        ],
        'inventory' => [
            'title' => 'Склад',
        ],
        'shipping' => [
            'title' => 'Доставка',
        ],
    ],
    'form' => [
        'sku' => [
            'label' => 'SKU',
        ],
        'gtin' => [
            'label' => 'Глобальний номер товару (GTIN)',
        ],
        'mpn' => [
            'label' => 'Номер деталі виробника (MPN)',
        ],
        'ean' => [
            'label' => 'UPC/EAN',
        ],
        'stock' => [
            'label' => 'В наявності',
        ],
        'backorder' => [
            'label' => 'Під замовлення',
        ],
        'purchasable' => [
            'label' => 'Доступність для купівлі',
            'options' => [
                'always' => 'Завжди',
                'in_stock' => 'В наявності',
                'in_stock_or_on_backorder' => 'В наявності або під замовлення',
            ],
        ],
        'unit_quantity' => [
            'label' => 'Кількість у одиниці',
            'helper_text' => 'Скільки окремих одиниць складають 1 одиницю.',
        ],
        'min_quantity' => [
            'label' => 'Мінімальна кількість',
            'helper_text' => 'Мінімальна кількість варіанта товару, яку можна придбати за одну покупку.',
        ],
        'quantity_increment' => [
            'label' => 'Крок кількості',
            'helper_text' => 'Варіант товару потрібно купувати кратно цій кількості.',
        ],
        'tax_class_id' => [
            'label' => 'Клас податку',
        ],
        'shippable' => [
            'label' => 'Можна доставляти',
        ],
        'length_value' => [
            'label' => 'Довжина',
        ],
        'length_unit' => [
            'label' => 'Одиниця довжини',
        ],
        'width_value' => [
            'label' => 'Ширина',
        ],
        'width_unit' => [
            'label' => 'Одиниця ширини',
        ],
        'height_value' => [
            'label' => 'Висота',
        ],
        'height_unit' => [
            'label' => 'Одиниця висоти',
        ],
        'weight_value' => [
            'label' => 'Вага',
        ],
        'weight_unit' => [
            'label' => 'Одиниця ваги',
        ],
    ],
];
