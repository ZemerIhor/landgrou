<?php

return [

    'label' => 'Група атрибутів',

    'plural_label' => 'Групи атрибутів',

    'table' => [
        'attributable_type' => [
            'label' => 'Тип',
        ],
        'name' => [
            'label' => 'Назва',
        ],
        'handle' => [
            'label' => 'Службовий ключ',
        ],
        'position' => [
            'label' => 'Позиція',
        ],
    ],

    'form' => [
        'attributable_type' => [
            'label' => 'Тип',
        ],
        'name' => [
            'label' => 'Назва',
        ],
        'handle' => [
            'label' => 'Службовий ключ',
        ],
        'position' => [
            'label' => 'Позиція',
        ],
    ],

    'action' => [
        'delete' => [
            'notification' => [
                'error_protected' => 'Цю групу атрибутів не можна видалити, оскільки до неї прив’язані атрибути.',
            ],
        ],
    ],
];
