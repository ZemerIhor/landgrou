<?php

return [

    'column_toggle' => [

        'heading' => 'Колонки',

    ],

    'columns' => [

        'actions' => [
            'label' => 'Дія|Дії',
        ],

        'text' => [

            'actions' => [
                'collapse_list' => 'Показати на :count менше',
                'expand_list' => 'Показати на :count більше',
            ],

            'more_list_items' => 'і ще :count',

        ],

    ],

    'fields' => [

        'bulk_select_page' => [
            'label' => 'Вибрати/зняти вибір усіх елементів для масових дій.',
        ],

        'bulk_select_record' => [
            'label' => 'Вибрати/зняти вибір елемента :key для масових дій.',
        ],

        'bulk_select_group' => [
            'label' => 'Вибрати/зняти вибір групи :title для масових дій.',
        ],

        'search' => [
            'label' => 'Пошук',
            'placeholder' => 'Пошук',
            'indicator' => 'Пошук',
        ],

    ],

    'summary' => [

        'heading' => 'Підсумок',

        'subheadings' => [
            'all' => 'Усі :label',
            'group' => 'Підсумок групи :group',
            'page' => 'Ця сторінка',
        ],

        'summarizers' => [

            'average' => [
                'label' => 'Середнє',
            ],

            'count' => [
                'label' => 'Кількість',
            ],

            'sum' => [
                'label' => 'Сума',
            ],

        ],

    ],

    'actions' => [

        'disable_reordering' => [
            'label' => 'Завершити впорядкування записів',
        ],

        'enable_reordering' => [
            'label' => 'Впорядкувати записи',
        ],

        'filter' => [
            'label' => 'Фільтр',
        ],

        'group' => [
            'label' => 'Групувати',
        ],

        'open_bulk_actions' => [
            'label' => 'Масові дії',
        ],

        'toggle_columns' => [
            'label' => 'Показ колонок',
        ],

    ],

    'empty' => [

        'heading' => 'Немає :model',

        'description' => 'Створіть :model, щоб розпочати.',

    ],

    'filters' => [

        'actions' => [

            'apply' => [
                'label' => 'Застосувати фільтри',
            ],

            'remove' => [
                'label' => 'Прибрати фільтр',
            ],

            'remove_all' => [
                'label' => 'Прибрати всі фільтри',
                'tooltip' => 'Прибрати всі фільтри',
            ],

            'reset' => [
                'label' => 'Скинути',
            ],

        ],

        'heading' => 'Фільтри',

        'indicator' => 'Активні фільтри',

        'multi_select' => [
            'placeholder' => 'Усі',
        ],

        'select' => [
            'placeholder' => 'Усі',
        ],

        'trashed' => [

            'label' => 'Видалені записи',

            'only_trashed' => 'Лише видалені записи',

            'with_trashed' => 'З видаленими записами',

            'without_trashed' => 'Без видалених записів',

        ],

    ],

    'grouping' => [

        'fields' => [

            'group' => [
                'label' => 'Групувати за',
                'placeholder' => 'Групувати за',
            ],

            'direction' => [

                'label' => 'Напрям групування',

                'options' => [
                    'asc' => 'За зростанням',
                    'desc' => 'За спаданням',
                ],

            ],

        ],

    ],

    'reorder_indicator' => 'Перетягніть записи, щоб упорядкувати.',

    'selection_indicator' => [

        'selected_count' => 'Вибрано 1 запис|Вибрано :count записів',

        'actions' => [

            'select_all' => [
                'label' => 'Вибрати всі :count',
            ],

            'deselect_all' => [
                'label' => 'Зняти вибір з усіх',
            ],

        ],

    ],

    'sorting' => [

        'fields' => [

            'column' => [
                'label' => 'Сортувати за',
            ],

            'direction' => [

                'label' => 'Напрям сортування',

                'options' => [
                    'asc' => 'За зростанням',
                    'desc' => 'За спаданням',
                ],

            ],

        ],

    ],

];
