<?php

return [

    'label' => 'Навігація сторінок',

    'overview' => '{1} Показано 1 результат|[2,*] Показано з :first по :last із :total результатів',

    'fields' => [

        'records_per_page' => [

            'label' => 'На сторінці',

            'options' => [
                'all' => 'Усі',
            ],

        ],

    ],

    'actions' => [

        'first' => [
            'label' => 'Перша',
        ],

        'go_to_page' => [
            'label' => 'Перейти на сторінку :page',
        ],

        'last' => [
            'label' => 'Остання',
        ],

        'next' => [
            'label' => 'Наступна',
        ],

        'previous' => [
            'label' => 'Попередня',
        ],

    ],

];
