<?php

return [

    'label' => 'Група колекцій',

    'plural_label' => 'Групи колекцій',

    'table' => [
        'name' => [
            'label' => 'Назва',
        ],
        'handle' => [
            'label' => 'Службовий ключ',
        ],
        'collections_count' => [
            'label' => 'Кількість колекцій',
        ],
    ],

    'form' => [
        'name' => [
            'label' => 'Назва',
        ],
        'handle' => [
            'label' => 'Службовий ключ',
        ],
    ],

    'action' => [
        'delete' => [
            'notification' => [
                'error_protected' => 'Цю групу колекцій не можна видалити, оскільки з нею пов’язані колекції.',
            ],
        ],
    ],
];
