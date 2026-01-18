<?php

return [

    'label' => 'Замовлення',

    'plural_label' => 'Замовлення',

    'breadcrumb' => [
        'manage' => 'Керування',
    ],

    'tabs' => [
        'all' => 'Усі',
    ],

    'transactions' => [
        'capture' => 'Списано',
        'intent' => 'Намір',
        'refund' => 'Повернено',
        'failed' => 'Помилка',
    ],

    'table' => [
        'status' => [
            'label' => 'Статус',
        ],
        'reference' => [
            'label' => 'Референс',
        ],
        'customer_reference' => [
            'label' => 'Референс клієнта',
        ],
        'customer' => [
            'label' => 'Клієнт',
        ],
        'tags' => [
            'label' => 'Теги',
        ],
        'postcode' => [
            'label' => 'Поштовий індекс',
        ],
        'email' => [
            'label' => 'Email',
            'copy_message' => 'Email-адресу скопійовано',
        ],
        'phone' => [
            'label' => 'Телефон',
        ],
        'total' => [
            'label' => 'Разом',
        ],
        'date' => [
            'label' => 'Дата',
        ],
        'new_customer' => [
            'label' => 'Тип клієнта',
        ],
        'placed_after' => [
            'label' => 'Оформлено після',
        ],
        'placed_before' => [
            'label' => 'Оформлено до',
        ],
    ],

    'form' => [
        'address' => [
            'first_name' => [
                'label' => 'Ім’я',
            ],
            'last_name' => [
                'label' => 'Прізвище',
            ],
            'line_one' => [
                'label' => 'Адреса (рядок 1)',
            ],
            'line_two' => [
                'label' => 'Адреса (рядок 2)',
            ],
            'line_three' => [
                'label' => 'Адреса (рядок 3)',
            ],
            'company_name' => [
                'label' => 'Назва компанії',
            ],
            'tax_identifier' => [
                'label' => 'Податковий ідентифікатор',
            ],
            'contact_phone' => [
                'label' => 'Телефон',
            ],
            'contact_email' => [
                'label' => 'Email',
            ],
            'city' => [
                'label' => 'Місто',
            ],
            'state' => [
                'label' => 'Область / Провінція',
            ],
            'postcode' => [
                'label' => 'Поштовий індекс',
            ],
            'country_id' => [
                'label' => 'Країна',
            ],
        ],

        'reference' => [
            'label' => 'Референс',
        ],
        'status' => [
            'label' => 'Статус',
        ],
        'transaction' => [
            'label' => 'Транзакція',
        ],
        'amount' => [
            'label' => 'Сума',

            'hint' => [
                'less_than_total' => 'Ви збираєтеся списати суму, меншу за загальну суму транзакції',
            ],
        ],

        'notes' => [
            'label' => 'Нотатки',
        ],
        'confirm' => [
            'label' => 'Підтвердити',

            'alert' => 'Потрібне підтвердження',

            'hint' => [
                'capture' => 'Будь ласка, підтвердіть списання цього платежу',
                'refund' => 'Будь ласка, підтвердіть повернення цієї суми.',
            ],
        ],
    ],

    'infolist' => [
        'notes' => [
            'label' => 'Нотатки',
            'placeholder' => 'Для цього замовлення немає нотаток',
        ],
        'delivery_instructions' => [
            'label' => 'Інструкції з доставки',
        ],
        'shipping_total' => [
            'label' => 'Вартість доставки',
        ],
        'paid' => [
            'label' => 'Сплачено',
        ],
        'refund' => [
            'label' => 'Повернення',
        ],
        'unit_price' => [
            'label' => 'Ціна за одиницю',
        ],
        'quantity' => [
            'label' => 'Кількість',
        ],
        'sub_total' => [
            'label' => 'Проміжний підсумок',
        ],
        'discount_total' => [
            'label' => 'Сума знижки',
        ],
        'total' => [
            'label' => 'Разом',
        ],
        'current_stock_level' => [
            'message' => 'Поточний залишок: :count',
        ],
        'purchase_stock_level' => [
            'message' => 'на момент замовлення: :count',
        ],
        'status' => [
            'label' => 'Статус',
        ],
        'reference' => [
            'label' => 'Референс',
        ],
        'customer_reference' => [
            'label' => 'Референс клієнта',
        ],
        'channel' => [
            'label' => 'Канал',
        ],
        'date_created' => [
            'label' => 'Дата створення',
        ],
        'date_placed' => [
            'label' => 'Дата оформлення',
        ],
        'new_returning' => [
            'label' => 'Новий / Повторний',
        ],
        'new_customer' => [
            'label' => 'Новий клієнт',
        ],
        'returning_customer' => [
            'label' => 'Повторний клієнт',
        ],
        'shipping_address' => [
            'label' => 'Адреса доставки',
        ],
        'billing_address' => [
            'label' => 'Платіжна адреса',
        ],
        'address_not_set' => [
            'label' => 'Адресу не задано',
        ],
        'billing_matches_shipping' => [
            'label' => 'Збігається з адресою доставки',
        ],
        'additional_info' => [
            'label' => 'Додаткова інформація',
        ],
        'no_additional_info' => [
            'label' => 'Немає додаткової інформації',
        ],
        'tags' => [
            'label' => 'Теги',
        ],
        'timeline' => [
            'label' => 'Хронологія',
        ],
        'transactions' => [
            'label' => 'Транзакції',
            'placeholder' => 'Немає транзакцій',
        ],
        'alert' => [
            'requires_capture' => 'Це замовлення все ще потребує списання платежу.',
            'partially_refunded' => 'За цим замовленням виконано часткове повернення.',
            'refunded' => 'За цим замовленням виконано повернення.',
        ],
    ],

    'action' => [
        'bulk_update_status' => [
            'label' => 'Оновити статус',
            'notification' => 'Статуси замовлень оновлено',
        ],
        'update_status' => [
            'new_status' => [
                'label' => 'Новий статус',
            ],
            'additional_content' => [
                'label' => 'Додатковий вміст',
            ],
            'additional_email_recipient' => [
                'label' => 'Додатковий отримувач email',
                'placeholder' => 'необов’язково',
            ],
        ],
        'download_order_pdf' => [
            'label' => 'Завантажити PDF',
            'notification' => 'PDF замовлення завантажується',
        ],
        'edit_address' => [
            'label' => 'Редагувати',

            'notification' => [
                'error' => 'Помилка',

                'billing_address' => [
                    'saved' => 'Платіжну адресу збережено',
                ],

                'shipping_address' => [
                    'saved' => 'Адресу доставки збережено',
                ],
            ],
        ],
        'edit_tags' => [
            'label' => 'Редагувати',
            'form' => [
                'tags' => [
                    'label' => 'Теги',
                    'helper_text' => 'Розділяйте теги натисканням Enter, Tab або коми (,)',
                ],
            ],
        ],
        'capture_payment' => [
            'label' => 'Списати платіж',

            'notification' => [
                'error' => 'Виникла проблема зі списанням',
                'success' => 'Списання успішне',
            ],
        ],
        'refund_payment' => [
            'label' => 'Повернення',

            'notification' => [
                'error' => 'Виникла проблема з поверненням',
                'success' => 'Повернення успішне',
            ],
        ],
    ],

];
