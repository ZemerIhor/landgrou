<?php

return [

    'label' => 'Бренд',

    'plural_label' => 'Бренди',

    'table' => [
        'name' => [
            'label' => 'Назва',
        ],
        'products_count' => [
            'label' => 'Кількість товарів',
        ],
    ],

    'form' => [
        'name' => [
            'label' => 'Назва',
        ],
    ],

    'action' => [
        'delete' => [
            'notification' => [
                'error_protected' => 'Цей бренд не можна видалити, оскільки з ним пов’язані товари.',
            ],
        ],
    ],
    'pages' => [
        'edit' => [
            'title' => 'Основна інформація',
        ],
        'products' => [
            'label' => 'Товари',
            'actions' => [
                'attach' => [
                    'label' => 'Прив’язати товар',
                    'form' => [
                        'record_id' => [
                            'label' => 'Товар',
                        ],
                    ],
                    'notification' => [
                        'success' => 'Товар прив’язано до бренду',
                    ],
                ],
                'detach' => [
                    'notification' => [
                        'success' => 'Товар відв’язано.',
                    ],
                ],
            ],
        ],
        'collections' => [
            'label' => 'Колекції',
            'table' => [
                'header_actions' => [
                    'attach' => [
                        'record_select' => [
                            'placeholder' => 'Виберіть колекцію',
                        ],
                    ],
                ],
            ],
            'actions' => [
                'attach' => [
                    'label' => 'Прив’язати колекцію',
                ],
            ],
        ],
    ],

];
