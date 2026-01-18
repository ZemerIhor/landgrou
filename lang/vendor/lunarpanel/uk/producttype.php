<?php

return [

    'label' => 'Тип товару',

    'plural_label' => 'Типи товарів',

    'table' => [
        'name' => [
            'label' => 'Назва',
        ],
        'products_count' => [
            'label' => 'Кількість товарів',
        ],
        'product_attributes_count' => [
            'label' => 'Атрибути товару',
        ],
        'variant_attributes_count' => [
            'label' => 'Атрибути варіанта',
        ],
    ],

    'tabs' => [
        'product_attributes' => [
            'label' => 'Атрибути товару',
        ],
        'variant_attributes' => [
            'label' => 'Атрибути варіанта',
        ],
    ],

    'form' => [
        'name' => [
            'label' => 'Назва',
        ],
    ],

    'attributes' => [
        'no_groups' => 'Немає доступних груп атрибутів.',
        'no_attributes' => 'Немає доступних атрибутів.',
    ],

    'action' => [
        'delete' => [
            'notification' => [
                'error_protected' => 'Цей тип товару не можна видалити, оскільки з ним пов’язані товари.',
            ],
        ],
    ],

];
