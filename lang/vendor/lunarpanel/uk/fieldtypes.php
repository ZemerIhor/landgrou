<?php

return [
    'dropdown' => [
        'label' => 'Випадний список',
        'form' => [
            'lookups' => [
                'label' => 'Список значень',
                'key_label' => 'Мітка',
                'value_label' => 'Значення',
            ],
        ],
    ],
    'listfield' => [
        'label' => 'Поле списку',
    ],
    'text' => [
        'label' => 'Текст',
        'form' => [
            'richtext' => [
                'label' => 'Форматований текст',
            ],
        ],
    ],
    'translatedtext' => [
        'label' => 'Перекладений текст',
        'form' => [
            'richtext' => [
                'label' => 'Форматований текст',
            ],
            'locales' => 'Локалі',
        ],
    ],
    'toggle' => [
        'label' => 'Перемикач',
    ],
    'youtube' => [
        'label' => 'YouTube',
    ],
    'vimeo' => [
        'label' => 'Vimeo',
    ],
    'number' => [
        'label' => 'Число',
        'form' => [
            'min' => [
                'label' => 'Мін.',
            ],
            'max' => [
                'label' => 'Макс.',
            ],
        ],
    ],
    'file' => [
        'label' => 'Файл',
        'form' => [
            'file_types' => [
                'label' => 'Дозволені типи файлів',
                'placeholder' => 'Новий MIME',
            ],
            'multiple' => [
                'label' => 'Дозволити кілька файлів',
            ],
            'min_files' => [
                'label' => 'Мін. файлів',
            ],
            'max_files' => [
                'label' => 'Макс. файлів',
            ],
        ],
    ],
];
