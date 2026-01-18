<?php

return [

    'label' => 'Товар',

    'plural_label' => 'Товари',

    'tabs' => [
        'all' => 'Усі',
        'published' => 'Опубліковані',
        'draft' => 'Чернетки',
    ],

    'status' => [
        'unpublished' => [
            'content' => 'Наразі в статусі чернетки, цей товар приховано у всіх каналах і групах клієнтів.',
        ],
        'availability' => [
            'customer_groups' => 'Цей товар наразі недоступний для всіх груп клієнтів.',
            'channels' => 'Цей товар наразі недоступний для всіх каналів.',
        ],
    ],

    'table' => [
        'status' => [
            'label' => 'Статус',
            'states' => [
                'deleted' => 'Видалено',
                'draft' => 'Чернетка',
                'published' => 'Опубліковано',
            ],
        ],
        'name' => [
            'label' => 'Назва',
        ],
        'brand' => [
            'label' => 'Бренд',
        ],
        'sku' => [
            'label' => 'SKU',
        ],
        'stock' => [
            'label' => 'Наявність',
        ],
        'producttype' => [
            'label' => 'Тип товару',
        ],
    ],

    'actions' => [
        'edit_status' => [
            'label' => 'Оновити статус',
            'heading' => 'Оновити статус',
        ],
    ],

    'form' => [
        'name' => [
            'label' => 'Назва',
        ],
        'brand' => [
            'label' => 'Бренд',
        ],
        'sku' => [
            'label' => 'SKU',
        ],
        'producttype' => [
            'label' => 'Тип товару',
        ],
        'status' => [
            'label' => 'Статус',
            'options' => [
                'published' => [
                    'label' => 'Опубліковано',
                    'description' => 'Цей товар буде доступний у всіх увімкнених групах клієнтів і каналах',
                ],
                'draft' => [
                    'label' => 'Чернетка',
                    'description' => 'Цей товар буде прихований у всіх каналах і групах клієнтів',
                ],
            ],
        ],
        'tags' => [
            'label' => 'Теги',
            'helper_text' => 'Розділяйте теги натисканням Enter, Tab або коми (,)',
        ],
        'collections' => [
            'label' => 'Колекції',
            'select_collection' => 'Виберіть колекцію',
        ],
    ],

    'pages' => [
        'availability' => [
            'label' => 'Доступність',
        ],
        'edit' => [
            'title' => 'Основна інформація',
        ],
        'identifiers' => [
            'label' => 'Ідентифікатори товару',
        ],
        'inventory' => [
            'label' => 'Склад',
        ],
        'pricing' => [
            'form' => [
                'tax_class_id' => [
                    'label' => 'Клас податку',
                ],
                'tax_ref' => [
                    'label' => 'Податковий референс',
                    'helper_text' => 'Необов’язково, для інтеграції з системами третіх сторін.',
                ],
            ],
        ],
        'shipping' => [
            'label' => 'Доставка',
        ],
        'variants' => [
            'label' => 'Варіанти',
        ],
        'collections' => [
            'label' => 'Колекції',
            'select_collection' => 'Виберіть колекцію',
        ],
        'associations' => [
            'label' => 'Пов’язані товари',
        ],
    ],

];
