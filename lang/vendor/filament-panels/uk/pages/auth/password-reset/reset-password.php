<?php

return [

    'title' => 'Скидання пароля',

    'heading' => 'Скидання пароля',

    'form' => [

        'email' => [
            'label' => 'Email адреса',
        ],

        'password' => [
            'label' => 'Пароль',
            'validation_attribute' => 'пароль',
        ],

        'password_confirmation' => [
            'label' => 'Підтвердіть пароль',
        ],

        'actions' => [

            'reset' => [
                'label' => 'Скинути пароль',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Забагато спроб скидання',
            'body' => 'Будь ласка, спробуйте ще раз через :seconds секунд.',
        ],

    ],

];
