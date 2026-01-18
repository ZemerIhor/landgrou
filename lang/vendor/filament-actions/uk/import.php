<?php

return [

    'label' => 'Імпортувати :label',

    'modal' => [

        'heading' => 'Імпортувати :label',

        'form' => [

            'file' => [

                'label' => 'Файл',

                'placeholder' => 'Завантажте CSV файл',

                'rules' => [
                    'duplicate_columns' => '{0} Файл не повинен містити більше одного порожнього заголовка колонки.|{1,*} Файл не повинен містити дубльованих заголовків колонок: :columns.',
                ],

            ],

            'columns' => [
                'label' => 'Колонки',
                'placeholder' => 'Виберіть колонку',
            ],

        ],

        'actions' => [

            'download_example' => [
                'label' => 'Завантажити приклад CSV файлу',
            ],

            'import' => [
                'label' => 'Імпортувати',
            ],

        ],

    ],

    'notifications' => [

        'completed' => [

            'title' => 'Імпорт завершено',

            'actions' => [

                'download_failed_rows_csv' => [
                    'label' => 'Завантажити інформацію про помилковий рядок|Завантажити інформацію про помилкові рядки',
                ],

            ],

        ],

        'max_rows' => [
            'title' => 'Завантажений CSV файл занадто великий',
            'body' => 'Не можна імпортувати більше ніж 1 рядок за раз.|Не можна імпортувати більше ніж :count рядків за раз.',
        ],

        'started' => [
            'title' => 'Імпорт розпочато',
            'body' => 'Імпорт розпочато, 1 рядок буде оброблено у фоні.|Імпорт розпочато, :count рядків буде оброблено у фоні.',
        ],

    ],

    'example_csv' => [
        'file_name' => ':importer-example',
    ],

    'failure_csv' => [
        'file_name' => 'import-:import_id-:csv_name-failed-rows',
        'error_header' => 'помилка',
        'system_error' => 'Системна помилка, зверніться до підтримки.',
        'column_mapping_required_for_new_record' => 'Колонку :attribute не зіставлено з колонкою у файлі, але вона потрібна для створення нових записів.',
    ],

];
