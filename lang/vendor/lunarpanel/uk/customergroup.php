<?php

return [

    'label' => 'Група клієнтів',

    'plural_label' => 'Групи клієнтів',

    'table' => [
        'name' => [
            'label' => 'Назва',
        ],
        'handle' => [
            'label' => 'Службовий ключ',
        ],
        'default' => [
            'label' => 'За замовчуванням',
        ],
    ],

    'form' => [
        'name' => [
            'label' => 'Назва',
        ],
        'handle' => [
            'label' => 'Службовий ключ',
        ],
        'default' => [
            'label' => 'За замовчуванням',
        ],
    ],

    'action' => [
        'delete' => [
            'notification' => [
                'error_protected' => 'Цю групу клієнтів не можна видалити, оскільки з нею пов’язані клієнти.',
            ],
        ],
    ],
];
