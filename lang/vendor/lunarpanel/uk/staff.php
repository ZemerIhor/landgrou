<?php

return [

    'label' => 'Персонал',

    'plural_label' => 'Персонал',

    'table' => [
        'first_name' => [
            'label' => 'Ім’я',
        ],
        'last_name' => [
            'label' => 'Прізвище',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'admin' => [
            'badge' => 'Суперадмін',
        ],
    ],

    'form' => [
        'first_name' => [
            'label' => 'Ім’я',
        ],
        'last_name' => [
            'label' => 'Прізвище',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'password' => [
            'label' => 'Пароль',
            'hint' => 'Скинути пароль',
        ],
        'admin' => [
            'label' => 'Суперадмін',
            'helper' => 'Ролі суперадміністра не можна змінювати в хабі.',
        ],
        'roles' => [
            'label' => 'Ролі',
            'helper' => ':roles мають повний доступ',
        ],
        'permissions' => [
            'label' => 'Права доступу',
        ],
        'role' => [
            'label' => 'Назва ролі',
        ],
    ],

    'action' => [
        'acl' => [
            'label' => 'Контроль доступу',
        ],
        'add-role' => [
            'label' => 'Додати роль',
        ],
        'delete-role' => [
            'label' => 'Видалити роль',
            'heading' => 'Видалити роль: :role',
        ],
    ],

    'acl' => [
        'title' => 'Контроль доступу',
        'tooltip' => [
            'roles-included' => 'Право входить до таких ролей',
        ],
        'notification' => [
            'updated' => 'Оновлено',
            'error' => 'Помилка',
            'no-role' => 'Роль не зареєстрована в Lunar',
            'no-permission' => 'Право не зареєстроване в Lunar',
            'no-role-permission' => 'Роль і право не зареєстровані в Lunar',
        ],
    ],

];
