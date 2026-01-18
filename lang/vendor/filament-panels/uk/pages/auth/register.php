<?php

return [

    'title' => 'Реєстрація',

    'heading' => 'Зареєструватися',

    'actions' => [

        'login' => [
            'before' => 'або',
            'label' => 'увійдіть у свій обліковий запис',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'Email адреса',
        ],

        'name' => [
            'label' => 'Ім’я',
        ],

        'password' => [
            'label' => 'Пароль',
            'validation_attribute' => 'пароль',
        ],

        'password_confirmation' => [
            'label' => 'Підтвердіть пароль',
        ],

        'actions' => [

            'register' => [
                'label' => 'Зареєструватися',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Забагато спроб реєстрації',
            'body' => 'Будь ласка, спробуйте ще раз через :seconds секунд.',
        ],

    ],

];
