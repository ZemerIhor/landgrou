<?php

return [

    'label' => 'Атрибут',

    'plural_label' => 'Атрибути',

    'table' => [
        'name' => [
            'label' => 'Назва',
        ],
        'description' => [
            'label' => 'Опис',
        ],
        'handle' => [
            'label' => 'Службовий ключ',
        ],
        'type' => [
            'label' => 'Тип',
        ],
    ],

    'form' => [
        'attributable_type' => [
            'label' => 'Тип',
        ],
        'name' => [
            'label' => 'Назва',
        ],
        'description' => [
            'label' => 'Опис',
            'helper' => 'Використовуйте, щоб показати допоміжний текст під полем',
        ],
        'handle' => [
            'label' => 'Службовий ключ',
        ],
        'searchable' => [
            'label' => 'Доступний для пошуку',
        ],
        'filterable' => [
            'label' => 'Доступний для фільтрації',
        ],
        'required' => [
            'label' => 'Обов’язковий',
        ],
        'type' => [
            'label' => 'Тип',
        ],
        'validation_rules' => [
            'label' => 'Правила валідації',
            'helper' => 'Правила для поля атрибута, приклад: min:1|max:10|...',
        ],
    ],
];
