<?php

return [

    'title' => 'Підтвердьте вашу email адресу',

    'heading' => 'Підтвердьте вашу email адресу',

    'actions' => [

        'resend_notification' => [
            'label' => 'Надіслати повторно',
        ],

    ],

    'messages' => [
        'notification_not_received' => 'Не отримали листа, який ми надіслали?',
        'notification_sent' => 'Ми надіслали лист на :email з інструкціями щодо підтвердження вашої email адреси.',
    ],

    'notifications' => [

        'notification_resent' => [
            'title' => 'Ми повторно надіслали лист.',
        ],

        'notification_resend_throttled' => [
            'title' => 'Забагато спроб повторного надсилання',
            'body' => 'Будь ласка, спробуйте ще раз через :seconds секунд.',
        ],

    ],

];
