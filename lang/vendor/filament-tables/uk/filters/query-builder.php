<?php

return [

    'label' => 'Конструктор запитів',

    'form' => [

        'operator' => [
            'label' => 'Оператор',
        ],

        'or_groups' => [

            'label' => 'Групи',

            'block' => [
                'label' => 'Диз’юнкція (АБО)',
                'or' => 'АБО',
            ],

        ],

        'rules' => [

            'label' => 'Правила',

            'item' => [
                'and' => 'І',
            ],

        ],

    ],

    'no_rules' => '(Немає правил)',

    'item_separators' => [
        'and' => 'І',
        'or' => 'АБО',
    ],

    'operators' => [

        'is_filled' => [

            'label' => [
                'direct' => 'Заповнено',
                'inverse' => 'Порожньо',
            ],

            'summary' => [
                'direct' => ':attribute заповнено',
                'inverse' => ':attribute порожнє',
            ],

        ],

        'boolean' => [

            'is_true' => [

                'label' => [
                    'direct' => 'Істина',
                    'inverse' => 'Хибне',
                ],

                'summary' => [
                    'direct' => ':attribute істинне',
                    'inverse' => ':attribute хибне',
                ],

            ],

        ],

        'date' => [

            'is_after' => [

                'label' => [
                    'direct' => 'Після',
                    'inverse' => 'Не після',
                ],

                'summary' => [
                    'direct' => ':attribute після :date',
                    'inverse' => ':attribute не після :date',
                ],

            ],

            'is_before' => [

                'label' => [
                    'direct' => 'До',
                    'inverse' => 'Не до',
                ],

                'summary' => [
                    'direct' => ':attribute до :date',
                    'inverse' => ':attribute не до :date',
                ],

            ],

            'is_date' => [

                'label' => [
                    'direct' => 'Дата',
                    'inverse' => 'Не дата',
                ],

                'summary' => [
                    'direct' => ':attribute :date',
                    'inverse' => ':attribute не :date',
                ],

            ],

            'is_month' => [

                'label' => [
                    'direct' => 'Місяць',
                    'inverse' => 'Не місяць',
                ],

                'summary' => [
                    'direct' => ':attribute :month',
                    'inverse' => ':attribute не :month',
                ],

            ],

            'is_year' => [

                'label' => [
                    'direct' => 'Рік',
                    'inverse' => 'Не рік',
                ],

                'summary' => [
                    'direct' => ':attribute :year',
                    'inverse' => ':attribute не :year',
                ],

            ],

            'form' => [

                'date' => [
                    'label' => 'Дата',
                ],

                'month' => [
                    'label' => 'Місяць',
                ],

                'year' => [
                    'label' => 'Рік',
                ],

            ],

        ],

        'number' => [

            'equals' => [

                'label' => [
                    'direct' => 'Дорівнює',
                    'inverse' => 'Не дорівнює',
                ],

                'summary' => [
                    'direct' => ':attribute дорівнює :number',
                    'inverse' => ':attribute не дорівнює :number',
                ],

            ],

            'is_max' => [

                'label' => [
                    'direct' => 'Максимум',
                    'inverse' => 'Більше ніж',
                ],

                'summary' => [
                    'direct' => ':attribute максимум :number',
                    'inverse' => ':attribute більше ніж :number',
                ],

            ],

            'is_min' => [

                'label' => [
                    'direct' => 'Мінімум',
                    'inverse' => 'Менше ніж',
                ],

                'summary' => [
                    'direct' => ':attribute мінімум :number',
                    'inverse' => ':attribute менше ніж :number',
                ],

            ],

            'aggregates' => [

                'average' => [
                    'label' => 'Середнє',
                    'summary' => 'Середнє :attribute',
                ],

                'max' => [
                    'label' => 'Макс',
                    'summary' => 'Макс :attribute',
                ],

                'min' => [
                    'label' => 'Мін',
                    'summary' => 'Мін :attribute',
                ],

                'sum' => [
                    'label' => 'Сума',
                    'summary' => 'Сума :attribute',
                ],

            ],

            'form' => [

                'aggregate' => [
                    'label' => 'Агрегат',
                ],

                'number' => [
                    'label' => 'Число',
                ],

            ],

        ],

        'relationship' => [

            'equals' => [

                'label' => [
                    'direct' => 'Має',
                    'inverse' => 'Не має',
                ],

                'summary' => [
                    'direct' => 'Має :count :relationship',
                    'inverse' => 'Не має :count :relationship',
                ],

            ],

            'has_max' => [

                'label' => [
                    'direct' => 'Має максимум',
                    'inverse' => 'Має більше ніж',
                ],

                'summary' => [
                    'direct' => 'Має максимум :count :relationship',
                    'inverse' => 'Має більше ніж :count :relationship',
                ],

            ],

            'has_min' => [

                'label' => [
                    'direct' => 'Має мінімум',
                    'inverse' => 'Має менше ніж',
                ],

                'summary' => [
                    'direct' => 'Має мінімум :count :relationship',
                    'inverse' => 'Має менше ніж :count :relationship',
                ],

            ],

            'is_empty' => [

                'label' => [
                    'direct' => 'Порожній',
                    'inverse' => 'Не порожній',
                ],

                'summary' => [
                    'direct' => ':relationship порожній',
                    'inverse' => ':relationship не порожній',
                ],

            ],

            'is_related_to' => [

                'label' => [

                    'single' => [
                        'direct' => 'Є',
                        'inverse' => 'Не є',
                    ],

                    'multiple' => [
                        'direct' => 'Містить',
                        'inverse' => 'Не містить',
                    ],

                ],

                'summary' => [

                    'single' => [
                        'direct' => ':relationship є :values',
                        'inverse' => ':relationship не є :values',
                    ],

                    'multiple' => [
                        'direct' => ':relationship містить :values',
                        'inverse' => ':relationship не містить :values',
                    ],

                    'values_glue' => [
                        0 => ', ',
                        'final' => ' або ',
                    ],

                ],

                'form' => [

                    'value' => [
                        'label' => 'Значення',
                    ],

                    'values' => [
                        'label' => 'Значення',
                    ],

                ],

            ],

            'form' => [

                'count' => [
                    'label' => 'Кількість',
                ],

            ],

        ],

        'select' => [

            'is' => [

                'label' => [
                    'direct' => 'Є',
                    'inverse' => 'Не є',
                ],

                'summary' => [
                    'direct' => ':attribute є :values',
                    'inverse' => ':attribute не є :values',
                    'values_glue' => [
                        ', ',
                        'final' => ' або ',
                    ],
                ],

                'form' => [

                    'value' => [
                        'label' => 'Значення',
                    ],

                    'values' => [
                        'label' => 'Значення',
                    ],

                ],

            ],

        ],

        'text' => [

            'contains' => [

                'label' => [
                    'direct' => 'Містить',
                    'inverse' => 'Не містить',
                ],

                'summary' => [
                    'direct' => ':attribute містить :text',
                    'inverse' => ':attribute не містить :text',
                ],

            ],

            'ends_with' => [

                'label' => [
                    'direct' => 'Закінчується на',
                    'inverse' => 'Не закінчується на',
                ],

                'summary' => [
                    'direct' => ':attribute закінчується на :text',
                    'inverse' => ':attribute не закінчується на :text',
                ],

            ],

            'equals' => [

                'label' => [
                    'direct' => 'Дорівнює',
                    'inverse' => 'Не дорівнює',
                ],

                'summary' => [
                    'direct' => ':attribute дорівнює :text',
                    'inverse' => ':attribute не дорівнює :text',
                ],

            ],

            'starts_with' => [

                'label' => [
                    'direct' => 'Починається з',
                    'inverse' => 'Не починається з',
                ],

                'summary' => [
                    'direct' => ':attribute починається з :text',
                    'inverse' => ':attribute не починається з :text',
                ],

            ],

            'form' => [

                'text' => [
                    'label' => 'Текст',
                ],

            ],

        ],

    ],

    'actions' => [

        'add_rule' => [
            'label' => 'Додати правило',
        ],

        'add_rule_group' => [
            'label' => 'Додати групу правил',
        ],

    ],

];
