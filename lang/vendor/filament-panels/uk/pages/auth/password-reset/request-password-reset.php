<?php

return [

    'title' => 'Скидання пароля',

    'heading' => 'Забули пароль?',

    'actions' => [

        'login' => [
            'label' => 'назад до входу',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'Email адреса',
        ],

        'actions' => [

            'request' => [
                'label' => 'Надіслати лист',
            ],

        ],

    ],

    'notifications' => [

        'sent' => [
            'body' => 'Якщо ваш акаунт не існує, ви не отримаєте листа.',
        ],

        'throttled' => [
            'title' => 'Забагато запитів',
            'body' => 'Будь ласка, спробуйте ще раз через :seconds секунд.',
        ],

    ],

];
