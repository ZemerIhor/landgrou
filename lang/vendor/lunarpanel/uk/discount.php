<?php

return [
    'plural_label' => 'Знижки',
    'label' => 'Знижка',
    'form' => [
        'conditions' => [
            'heading' => 'Умови',
        ],
        'buy_x_get_y' => [
            'heading' => 'Купи X — отримай Y',
        ],
        'amount_off' => [
            'heading' => 'Знижка на суму',
        ],
        'name' => [
            'label' => 'Назва',
        ],
        'handle' => [
            'label' => 'Службовий ключ',
        ],
        'starts_at' => [
            'label' => 'Дата початку',
        ],
        'ends_at' => [
            'label' => 'Дата завершення',
        ],
        'priority' => [
            'label' => 'Пріоритет',
            'helper_text' => 'Знижки з вищим пріоритетом застосовуються першими.',
            'options' => [
                'low' => [
                    'label' => 'Низький',
                ],
                'medium' => [
                    'label' => 'Середній',
                ],
                'high' => [
                    'label' => 'Високий',
                ],
            ],
        ],
        'stop' => [
            'label' => 'Зупиняти інші знижки після цієї',
        ],
        'coupon' => [
            'label' => 'Купон',
            'helper_text' => 'Введіть купон, потрібний для застосування знижки. Якщо залишити порожнім — застосовується автоматично.',
        ],
        'max_uses' => [
            'label' => 'Макс. кількість використань',
            'helper_text' => 'Залиште порожнім для необмеженої кількості.',
        ],
        'max_uses_per_user' => [
            'label' => 'Макс. використань на користувача',
            'helper_text' => 'Залиште порожнім для необмеженої кількості.',
        ],
        'minimum_cart_amount' => [
            'label' => 'Мінімальна сума кошика',
        ],
        'min_qty' => [
            'label' => 'Кількість товару',
            'helper_text' => 'Вкажіть, скільки товарів потрібно для застосування знижки.',
        ],
        'reward_qty' => [
            'label' => 'Кількість безкоштовних одиниць',
            'helper_text' => 'Скільки одиниць кожного товару отримує знижку.',
        ],
        'max_reward_qty' => [
            'label' => 'Максимальна кількість винагород',
            'helper_text' => 'Максимальна кількість товарів, які можуть бути зі знижкою, незалежно від критеріїв.',
        ],
        'automatic_rewards' => [
            'label' => 'Автоматично додавати винагороди',
            'helper_text' => 'Увімкніть, щоб додавати товари-винагороди, якщо їх немає в кошику.',
        ],
        'fixed_value' => [
            'label' => 'Фіксоване значення',
        ],
        'percentage' => [
            'label' => 'Відсоток',
        ],
    ],
    'table' => [
        'name' => [
            'label' => 'Назва',
        ],
        'status' => [
            'label' => 'Статус',
            \Lunar\Models\Discount::ACTIVE => [
                'label' => 'Активна',
            ],
            \Lunar\Models\Discount::PENDING => [
                'label' => 'Очікує',
            ],
            \Lunar\Models\Discount::EXPIRED => [
                'label' => 'Минув термін',
            ],
            \Lunar\Models\Discount::SCHEDULED => [
                'label' => 'Запланована',
            ],
        ],
        'type' => [
            'label' => 'Тип',
        ],
        'starts_at' => [
            'label' => 'Дата початку',
        ],
        'ends_at' => [
            'label' => 'Дата завершення',
        ],
        'created_at' => [
            'label' => 'Створено',
        ],
        'coupon' => [
            'label' => 'Купон',
        ],
    ],
    'pages' => [
        'availability' => [
            'label' => 'Доступність',
        ],
        'edit' => [
            'title' => 'Основна інформація',
        ],
        'limitations' => [
            'label' => 'Обмеження',
        ],
    ],
    'relationmanagers' => [
        'collections' => [
            'title' => 'Колекції',
            'description' => 'Виберіть, на які колекції має бути обмежена ця знижка.',
            'actions' => [
                'attach' => [
                    'label' => 'Прив’язати колекцію',
                ],
            ],
            'table' => [
                'name' => [
                    'label' => 'Назва',
                ],
                'type' => [
                    'label' => 'Тип',
                    'limitation' => [
                        'label' => 'Обмеження',
                    ],
                    'exclusion' => [
                        'label' => 'Виключення',
                    ],
                ],
            ],
            'form' => [
                'type' => [
                    'options' => [
                        'limitation' => [
                            'label' => 'Обмеження',
                        ],
                        'exclusion' => [
                            'label' => 'Виключення',
                        ],
                    ],
                ],
            ],
        ],
        'customers' => [
            'title' => 'Клієнти',
            'description' => 'Виберіть, на яких клієнтів має бути обмежена ця знижка.',
            'actions' => [
                'attach' => [
                    'label' => 'Додати клієнта',
                ],
            ],
            'table' => [
                'name' => [
                    'label' => 'Назва',
                ],
            ],
        ],
        'brands' => [
            'title' => 'Бренди',
            'description' => 'Виберіть, на які бренди має бути обмежена ця знижка.',
            'actions' => [
                'attach' => [
                    'label' => 'Додати бренд',
                ],
            ],
            'table' => [
                'name' => [
                    'label' => 'Назва',
                ],
                'type' => [
                    'label' => 'Тип',
                    'limitation' => [
                        'label' => 'Обмеження',
                    ],
                    'exclusion' => [
                        'label' => 'Виключення',
                    ],
                ],
            ],
            'form' => [
                'type' => [
                    'options' => [
                        'limitation' => [
                            'label' => 'Обмеження',
                        ],
                        'exclusion' => [
                            'label' => 'Виключення',
                        ],
                    ],
                ],
            ],
        ],
        'products' => [
            'title' => 'Товари',
            'description' => 'Виберіть, на які товари має бути обмежена ця знижка.',
            'actions' => [
                'attach' => [
                    'label' => 'Додати товар',
                ],
            ],
            'table' => [
                'name' => [
                    'label' => 'Назва',
                ],
                'type' => [
                    'label' => 'Тип',
                    'limitation' => [
                        'label' => 'Обмеження',
                    ],
                    'exclusion' => [
                        'label' => 'Виключення',
                    ],
                ],
            ],
            'form' => [
                'type' => [
                    'options' => [
                        'limitation' => [
                            'label' => 'Обмеження',
                        ],
                        'exclusion' => [
                            'label' => 'Виключення',
                        ],
                    ],
                ],
            ],
        ],
        'rewards' => [
            'title' => 'Винагороди',
            'description' => 'Виберіть, які товари отримають знижку, якщо вони є в кошику і виконані умови вище.',
            'actions' => [
                'attach' => [
                    'label' => 'Додати винагороду',
                ],
            ],
            'table' => [
                'name' => [
                    'label' => 'Назва',
                ],
                'type' => [
                    'label' => 'Тип',
                    'limitation' => [
                        'label' => 'Обмеження',
                    ],
                    'exclusion' => [
                        'label' => 'Виключення',
                    ],
                ],
            ],
            'form' => [
                'type' => [
                    'options' => [
                        'limitation' => [
                            'label' => 'Обмеження',
                        ],
                        'exclusion' => [
                            'label' => 'Виключення',
                        ],
                    ],
                ],
            ],
        ],
        'conditions' => [
            'title' => 'Умови товарів і варіантів',
            'description' => 'Виберіть умови для товарів або варіантів, потрібні для застосування знижки.',
            'actions' => [
                'attach' => [
                    'label' => 'Додати умову',
                ],
            ],
            'table' => [
                'name' => [
                    'label' => 'Назва',
                ],
                'type' => [
                    'label' => 'Тип',
                    'limitation' => [
                        'label' => 'Обмеження',
                    ],
                    'exclusion' => [
                        'label' => 'Виключення',
                    ],
                ],
            ],
            'form' => [
                'type' => [
                    'options' => [
                        'limitation' => [
                            'label' => 'Обмеження',
                        ],
                        'exclusion' => [
                            'label' => 'Виключення',
                        ],
                    ],
                ],
            ],
        ],
        'collection_conditions' => [
            'title' => 'Умови колекцій',
            'description' => 'Виберіть умови колекцій, потрібні для застосування знижки.',
            'actions' => [
                'attach' => [
                    'label' => 'Додати умову',
                ],
            ],
            'table' => [
                'name' => [
                    'label' => 'Назва',
                ],
            ],
        ],
        'productvariants' => [
            'title' => 'Варіанти товару',
            'description' => 'Виберіть, на які варіанти товару має бути обмежена ця знижка.',
            'actions' => [
                'attach' => [
                    'label' => 'Додати варіант товару',
                ],
            ],
            'table' => [
                'name' => [
                    'label' => 'Назва',
                ],
                'sku' => [
                    'label' => 'SKU',
                ],
                'values' => [
                    'label' => 'Опції',
                ],
            ],
            'form' => [
                'type' => [
                    'options' => [
                        'limitation' => [
                            'label' => 'Обмеження',
                        ],
                        'exclusion' => [
                            'label' => 'Виключення',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
