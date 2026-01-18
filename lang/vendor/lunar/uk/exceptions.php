<?php

return [
    'non_purchasable_item' => 'Модель ":class" не реалізує інтерфейс purchasable.',
    'cart_line_id_mismatch' => 'Цей рядок кошика не належить до цього кошика',
    'invalid_cart_line_quantity' => 'Очікувана кількість не менша за "1", отримано ":quantity".',
    'maximum_cart_line_quantity' => 'Кількість не може перевищувати :quantity.',
    'carts.invalid_action' => 'Некоректна дія кошика',
    'carts.shipping_missing' => 'Потрібна адреса доставки',
    'carts.billing_missing' => 'Потрібна платіжна адреса',
    'carts.billing_incomplete' => 'Платіжна адреса неповна',
    'carts.order_exists' => 'Замовлення для цього кошика вже існує',
    'carts.shipping_option_missing' => 'Не вибрано спосіб доставки',
    'missing_currency_price' => 'Для валюти ":currency" не задано ціну',
    'minimum_quantity' => 'Потрібно додати мінімум :quantity шт.',
    'quantity_increment' => 'Кількість :quantity має бути кратною :increment',
    'fieldtype_missing' => 'FieldType ":class" не існує',
    'invalid_fieldtype' => 'Клас ":class" не реалізує інтерфейс FieldType.',
    'discounts.invalid_type' => 'Колекція має містити лише ":expected", знайдено ":actual"',
    'disallow_multiple_cart_orders' => 'Кошик може мати лише одне пов’язане замовлення.',
];
