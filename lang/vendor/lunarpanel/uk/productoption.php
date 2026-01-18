<?php

return [

    'label' => 'Опція товару',

    'plural_label' => 'Опції товару',

    'table' => [
        'name' => [
            'label' => 'Назва',
        ],
        'label' => [
            'label' => 'Мітка',
        ],
        'handle' => [
            'label' => 'Службовий ключ',
        ],
        'shared' => [
            'label' => 'Спільна',
        ],
    ],

    'form' => [
        'name' => [
            'label' => 'Назва',
        ],
        'label' => [
            'label' => 'Мітка',
        ],
        'handle' => [
            'label' => 'Службовий ключ',
        ],
    ],

    'widgets' => [
        'product-options' => [
            'notifications' => [
                'save-variants' => [
                    'success' => [
                        'title' => 'Варіанти товару збережено',
                    ],
                ],
            ],
            'actions' => [
                'cancel' => [
                    'label' => 'Скасувати',
                ],
                'save-options' => [
                    'label' => 'Зберегти опції',
                ],
                'add-shared-option' => [
                    'label' => 'Додати спільну опцію',
                    'form' => [
                        'product_option' => [
                            'label' => 'Опція товару',
                        ],
                        'no_shared_components' => [
                            'label' => 'Немає доступних спільних опцій.',
                        ],
                        'preselect' => [
                            'label' => 'Попередньо вибирати всі значення за замовчуванням.',
                        ],
                    ],
                ],
                'add-restricted-option' => [
                    'label' => 'Додати опцію',
                ],
            ],
            'options-list' => [
                'empty' => [
                    'heading' => 'Немає налаштованих опцій товару',
                    'description' => 'Додайте спільну або обмежену опцію товару, щоб почати створювати варіанти.',
                ],
            ],
            'options-table' => [
                'title' => 'Опції товару',
                'configure-options' => [
                    'label' => 'Налаштувати опції',
                ],
                'table' => [
                    'option' => [
                        'label' => 'Опція',
                    ],
                    'values' => [
                        'label' => 'Значення',
                    ],
                ],
            ],
            'variants-table' => [
                'title' => 'Варіанти товару',
                'actions' => [
                    'create' => [
                        'label' => 'Створити варіант',
                    ],
                    'edit' => [
                        'label' => 'Редагувати',
                    ],
                    'delete' => [
                        'label' => 'Видалити',
                    ],
                ],
                'empty' => [
                    'heading' => 'Варіанти не налаштовані',
                ],
                'table' => [
                    'new' => [
                        'label' => 'НОВИЙ',
                    ],
                    'option' => [
                        'label' => 'Опція',
                    ],
                    'sku' => [
                        'label' => 'SKU',
                    ],
                    'price' => [
                        'label' => 'Ціна',
                    ],
                    'stock' => [
                        'label' => 'Наявність',
                    ],
                ],
            ],
        ],
    ],

];
