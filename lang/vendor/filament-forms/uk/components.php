<?php

return [

    'builder' => [

        'actions' => [

            'clone' => [
                'label' => 'Клонувати',
            ],

            'add' => [

                'label' => 'Додати до :label',

                'modal' => [

                    'heading' => 'Додати до :label',

                    'actions' => [

                        'add' => [
                            'label' => 'Додати',
                        ],

                    ],

                ],

            ],

            'add_between' => [

                'label' => 'Вставити між блоками',

                'modal' => [

                    'heading' => 'Додати до :label',

                    'actions' => [

                        'add' => [
                            'label' => 'Додати',
                        ],

                    ],

                ],

            ],

            'delete' => [
                'label' => 'Видалити',
            ],

            'edit' => [

                'label' => 'Редагувати',

                'modal' => [

                    'heading' => 'Редагувати блок',

                    'actions' => [

                        'save' => [
                            'label' => 'Зберегти зміни',
                        ],

                    ],

                ],

            ],

            'reorder' => [
                'label' => 'Перемістити',
            ],

            'move_down' => [
                'label' => 'Перемістити вниз',
            ],

            'move_up' => [
                'label' => 'Перемістити вгору',
            ],

            'collapse' => [
                'label' => 'Згорнути',
            ],

            'expand' => [
                'label' => 'Розгорнути',
            ],

            'collapse_all' => [
                'label' => 'Згорнути все',
            ],

            'expand_all' => [
                'label' => 'Розгорнути все',
            ],

        ],

    ],

    'checkbox_list' => [

        'actions' => [

            'deselect_all' => [
                'label' => 'Зняти вибір з усіх',
            ],

            'select_all' => [
                'label' => 'Вибрати всі',
            ],

        ],

    ],

    'file_upload' => [

        'editor' => [

            'actions' => [

                'cancel' => [
                    'label' => 'Скасувати',
                ],

                'drag_crop' => [
                    'label' => 'Режим перетягування "кадрування"',
                ],

                'drag_move' => [
                    'label' => 'Режим перетягування "переміщення"',
                ],

                'flip_horizontal' => [
                    'label' => 'Віддзеркалити зображення по горизонталі',
                ],

                'flip_vertical' => [
                    'label' => 'Віддзеркалити зображення по вертикалі',
                ],

                'move_down' => [
                    'label' => 'Перемістити зображення вниз',
                ],

                'move_left' => [
                    'label' => 'Перемістити зображення ліворуч',
                ],

                'move_right' => [
                    'label' => 'Перемістити зображення праворуч',
                ],

                'move_up' => [
                    'label' => 'Перемістити зображення вгору',
                ],

                'reset' => [
                    'label' => 'Скинути',
                ],

                'rotate_left' => [
                    'label' => 'Повернути зображення ліворуч',
                ],

                'rotate_right' => [
                    'label' => 'Повернути зображення праворуч',
                ],

                'set_aspect_ratio' => [
                    'label' => 'Встановити співвідношення сторін :ratio',
                ],

                'save' => [
                    'label' => 'Зберегти',
                ],

                'zoom_100' => [
                    'label' => 'Масштаб 100%',
                ],

                'zoom_in' => [
                    'label' => 'Збільшити',
                ],

                'zoom_out' => [
                    'label' => 'Зменшити',
                ],

            ],

            'fields' => [

                'height' => [
                    'label' => 'Висота',
                    'unit' => 'px',
                ],

                'rotation' => [
                    'label' => 'Поворот',
                    'unit' => 'deg',
                ],

                'width' => [
                    'label' => 'Ширина',
                    'unit' => 'px',
                ],

                'x_position' => [
                    'label' => 'X',
                    'unit' => 'px',
                ],

                'y_position' => [
                    'label' => 'Y',
                    'unit' => 'px',
                ],

            ],

            'aspect_ratios' => [

                'label' => 'Співвідношення сторін',

                'no_fixed' => [
                    'label' => 'Вільно',
                ],

            ],

            'svg' => [

                'messages' => [
                    'confirmation' => "Редагування SVG не рекомендується, оскільки це може призвести до втрати якості під час масштабування.\n Ви впевнені, що хочете продовжити?",
                    'disabled' => 'Редагування SVG вимкнено, оскільки це може призвести до втрати якості під час масштабування.',
                ],

            ],

        ],

    ],

    'key_value' => [

        'actions' => [

            'add' => [
                'label' => 'Додати рядок',
            ],

            'delete' => [
                'label' => 'Видалити рядок',
            ],

            'reorder' => [
                'label' => 'Перемістити рядок',
            ],

        ],

        'fields' => [

            'key' => [
                'label' => 'Ключ',
            ],

            'value' => [
                'label' => 'Значення',
            ],

        ],

    ],

    'markdown_editor' => [

        'toolbar_buttons' => [
            'attach_files' => 'Додати файли',
            'blockquote' => 'Цитата',
            'bold' => 'Жирний',
            'bullet_list' => 'Маркерований список',
            'code_block' => 'Блок коду',
            'heading' => 'Заголовок',
            'italic' => 'Курсив',
            'link' => 'Посилання',
            'ordered_list' => 'Нумерований список',
            'redo' => 'Повторити',
            'strike' => 'Закреслений',
            'table' => 'Таблиця',
            'undo' => 'Скасувати',
        ],

    ],

    'radio' => [

        'boolean' => [
            'true' => 'Так',
            'false' => 'Ні',
        ],

    ],

    'repeater' => [

        'actions' => [

            'add' => [
                'label' => 'Додати до :label',
            ],

            'add_between' => [
                'label' => 'Вставити між',
            ],

            'delete' => [
                'label' => 'Видалити',
            ],

            'clone' => [
                'label' => 'Клонувати',
            ],

            'reorder' => [
                'label' => 'Перемістити',
            ],

            'move_down' => [
                'label' => 'Перемістити вниз',
            ],

            'move_up' => [
                'label' => 'Перемістити вгору',
            ],

            'collapse' => [
                'label' => 'Згорнути',
            ],

            'expand' => [
                'label' => 'Розгорнути',
            ],

            'collapse_all' => [
                'label' => 'Згорнути все',
            ],

            'expand_all' => [
                'label' => 'Розгорнути все',
            ],

        ],

    ],

    'rich_editor' => [

        'dialogs' => [

            'link' => [

                'actions' => [
                    'link' => 'Додати посилання',
                    'unlink' => 'Прибрати посилання',
                ],

                'label' => 'URL',

                'placeholder' => 'Введіть URL',

            ],

        ],

        'toolbar_buttons' => [
            'attach_files' => 'Додати файли',
            'blockquote' => 'Цитата',
            'bold' => 'Жирний',
            'bullet_list' => 'Маркерований список',
            'code_block' => 'Блок коду',
            'h1' => 'Заголовок',
            'h2' => 'Заголовок',
            'h3' => 'Підзаголовок',
            'italic' => 'Курсив',
            'link' => 'Посилання',
            'ordered_list' => 'Нумерований список',
            'redo' => 'Повторити',
            'strike' => 'Закреслений',
            'underline' => 'Підкреслений',
            'undo' => 'Скасувати',
        ],

    ],

    'select' => [

        'actions' => [

            'create_option' => [

                'label' => 'Створити',

                'modal' => [

                    'heading' => 'Створити',

                    'actions' => [

                        'create' => [
                            'label' => 'Створити',
                        ],

                        'create_another' => [
                            'label' => 'Створити й створити ще один',
                        ],

                    ],

                ],

            ],

            'edit_option' => [

                'label' => 'Редагувати',

                'modal' => [

                    'heading' => 'Редагувати',

                    'actions' => [

                        'save' => [
                            'label' => 'Зберегти',
                        ],

                    ],

                ],

            ],

        ],

        'boolean' => [
            'true' => 'Так',
            'false' => 'Ні',
        ],

        'loading_message' => 'Завантаження...',

        'max_items_message' => 'Можна вибрати лише :count.',

        'no_search_results_message' => 'Немає варіантів за вашим запитом.',

        'placeholder' => 'Виберіть опцію',

        'searching_message' => 'Пошук...',

        'search_prompt' => 'Почніть вводити для пошуку...',

    ],

    'tags_input' => [
        'placeholder' => 'Новий тег',
    ],

    'text_input' => [

        'actions' => [

            'hide_password' => [
                'label' => 'Сховати пароль',
            ],

            'show_password' => [
                'label' => 'Показати пароль',
            ],

        ],

    ],

    'toggle_buttons' => [

        'boolean' => [
            'true' => 'Так',
            'false' => 'Ні',
        ],

    ],

    'wizard' => [

        'actions' => [

            'previous_step' => [
                'label' => 'Назад',
            ],

            'next_step' => [
                'label' => 'Далі',
            ],

        ],

    ],

];
