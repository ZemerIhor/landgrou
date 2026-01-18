<?php

declare(strict_types=1);

return [
    'form' => [
        'title' => 'Назва',
        'url' => 'URL',
        'linkable_type' => 'Тип',
        'linkable_id' => 'ID',
    ],
    'resource' => [
        'name' => [
            'label' => 'Назва',
        ],
        'locations' => [
            'label' => 'Розташування',
            'empty' => 'Не призначено',
        ],
        'items' => [
            'label' => 'Елементи',
        ],
        'is_visible' => [
            'label' => 'Видимість',
            'visible' => 'Видимий',
            'hidden' => 'Прихований',
        ],
    ],
    'actions' => [
        'add' => [
            'label' => 'Додати до меню',
        ],
        'indent' => 'Збільшити відступ',
        'unindent' => 'Зменшити відступ',
        'locations' => [
            'label' => 'Розташування',
            'heading' => 'Керування розташуваннями',
            'description' => 'Виберіть, яке меню відображається в кожному розташуванні.',
            'submit' => 'Оновити',
            'form' => [
                'location' => [
                    'label' => 'Розташування',
                ],
                'menu' => [
                    'label' => 'Призначене меню',
                ],
            ],
            'empty' => [
                'heading' => 'Немає зареєстрованих розташувань',
            ],
        ],
    ],
    'items' => [
        'expand' => 'Розгорнути',
        'collapse' => 'Згорнути',
        'empty' => [
            'heading' => 'У цьому меню немає елементів.',
        ],
    ],
    'custom_link' => 'Користувацьке посилання',
    'custom_text' => 'Користувацький текст',
    'open_in' => [
        'label' => 'Відкрити у',
        'options' => [
            'self' => 'Ця вкладка',
            'blank' => 'Нова вкладка',
            'parent' => 'Батьківська вкладка',
            'top' => 'Верхня вкладка',
        ],
    ],
    'notifications' => [
        'created' => [
            'title' => 'Посилання створено',
        ],
        'locations' => [
            'title' => 'Розташування меню оновлено',
        ],
    ],
    'panel' => [
        'empty' => [
            'heading' => 'Нічого не знайдено',
            'description' => 'У цьому меню немає елементів.',
        ],
        'pagination' => [
            'previous' => 'Попередня',
            'next' => 'Наступна',
        ],
    ],
];
