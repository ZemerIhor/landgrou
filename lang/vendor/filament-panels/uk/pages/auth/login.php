<?php

return [

    'title' => 'Вхід',

    'heading' => 'Увійти',

    'actions' => [

        'register' => [
            'before' => 'або',
            'label' => 'зареєструйте обліковий запис',
        ],

        'request_password_reset' => [
            'label' => 'Забули пароль?',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'Email адреса',
        ],

        'password' => [
            'label' => 'Пароль',
        ],

        'remember' => [
            'label' => 'Запам’ятати мене',
        ],

        'actions' => [

            'authenticate' => [
                'label' => 'Увійти',
            ],

        ],

    ],

    'messages' => [

        'failed' => 'Ці облікові дані не відповідають нашим записам.',

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Забагато спроб входу',
            'body' => 'Будь ласка, спробуйте ще раз через :seconds секунд.',
        ],

    ],

];
