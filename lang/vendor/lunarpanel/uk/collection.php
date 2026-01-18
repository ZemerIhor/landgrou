<?php

return [

    'label' => 'Колекція',

    'plural_label' => 'Колекції',

    'form' => [
        'name' => [
            'label' => 'Назва',
        ],
    ],

    'pages' => [
        'children' => [
            'label' => 'Дочірні колекції',
            'actions' => [
                'create_child' => [
                    'label' => 'Створити дочірню колекцію',
                ],
            ],
            'table' => [
                'children_count' => [
                    'label' => 'Кількість дочірніх',
                ],
                'name' => [
                    'label' => 'Назва',
                ],
            ],
        ],
        'edit' => [
            'label' => 'Основна інформація',
        ],
        'products' => [
            'label' => 'Товари',
            'actions' => [
                'attach' => [
                    'label' => 'Додати товар',
                ],
            ],
        ],
    ],

];
