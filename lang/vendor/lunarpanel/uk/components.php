<?php

return [
    'tags' => [
        'notification' => [

            'updated' => 'Теги оновлено',

        ],
    ],

    'activity-log' => [

        'input' => [

            'placeholder' => 'Додати коментар',

        ],

        'action' => [

            'add-comment' => 'Додати коментар',

        ],

        'system' => 'Система',

        'partials' => [
            'orders' => [
                'order_created' => 'Замовлення створено',

                'status_change' => 'Статус оновлено',

                'capture' => 'Платіж на суму :amount карткою, що закінчується на :last_four',

                'authorized' => 'Авторизація на суму :amount карткою, що закінчується на :last_four',

                'refund' => 'Повернення :amount на картку, що закінчується на :last_four',

                'address' => ':type оновлено',

                'billingAddress' => 'Платіжна адреса',

                'shippingAddress' => 'Адреса доставки',
            ],

            'update' => [
                'updated' => ':model оновлено',
            ],

            'create' => [
                'created' => ':model створено',
            ],

            'tags' => [
                'updated' => 'Теги оновлено',
                'added' => 'Додано',
                'removed' => 'Видалено',
            ],
        ],

        'notification' => [
            'comment_added' => 'Коментар додано',
        ],

    ],

    'forms' => [
        'youtube' => [
            'helperText' => 'Введіть ID відео YouTube, наприклад dQw4w9WgXcQ',
        ],
    ],

    'collection-tree-view' => [
        'actions' => [
            'move' => [
                'form' => [
                    'target_id' => [
                        'label' => 'Батьківська колекція',
                    ],
                ],
            ],
        ],
        'notifications' => [
            'collections-reordered' => [
                'success' => 'Колекції впорядковано',
            ],
            'node-expanded' => [
                'danger' => 'Не вдалося завантажити колекції',
            ],
            'delete' => [
                'danger' => 'Не вдалося видалити колекцію',
            ],
        ],
    ],

    'product-options-list' => [
        'add-option' => [
            'label' => 'Додати опцію',
        ],
        'delete-option' => [
            'label' => 'Видалити опцію',
        ],
        'remove-shared-option' => [
            'label' => 'Видалити спільну опцію',
        ],
        'add-value' => [
            'label' => 'Додати ще одне значення',
        ],
        'name' => [
            'label' => 'Назва',
        ],
        'values' => [
            'label' => 'Значення',
        ],
    ],
];
