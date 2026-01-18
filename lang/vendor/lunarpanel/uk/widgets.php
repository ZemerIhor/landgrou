<?php

return [
    'dashboard' => [
        'orders' => [
            'order_stats_overview' => [
                'stat_one' => [
                    'label' => 'Замовлень сьогодні',
                    'increase' => 'Зростання на :percentage% від :count учора',
                    'decrease' => 'Зниження на :percentage% від :count учора',
                    'neutral' => 'Без змін порівняно з учора',
                ],
                'stat_two' => [
                    'label' => 'Замовлень за останні 7 днів',
                    'increase' => 'Зростання на :percentage% від :count минулого періоду',
                    'decrease' => 'Зниження на :percentage% від :count минулого періоду',
                    'neutral' => 'Без змін порівняно з минулим періодом',
                ],
                'stat_three' => [
                    'label' => 'Замовлень за останні 30 днів',
                    'increase' => 'Зростання на :percentage% від :count минулого періоду',
                    'decrease' => 'Зниження на :percentage% від :count минулого періоду',
                    'neutral' => 'Без змін порівняно з минулим періодом',
                ],
                'stat_four' => [
                    'label' => 'Продажів сьогодні',
                    'increase' => 'Зростання на :percentage% від :total учора',
                    'decrease' => 'Зниження на :percentage% від :total учора',
                    'neutral' => 'Без змін порівняно з учора',
                ],
                'stat_five' => [
                    'label' => 'Продажів за останні 7 днів',
                    'increase' => 'Зростання на :percentage% від :total минулого періоду',
                    'decrease' => 'Зниження на :percentage% від :total минулого періоду',
                    'neutral' => 'Без змін порівняно з минулим періодом',
                ],
                'stat_six' => [
                    'label' => 'Продажів за останні 30 днів',
                    'increase' => 'Зростання на :percentage% від :total минулого періоду',
                    'decrease' => 'Зниження на :percentage% від :total минулого періоду',
                    'neutral' => 'Без змін порівняно з минулим періодом',
                ],
            ],
            'order_totals_chart' => [
                'heading' => 'Суми замовлень за останній рік',
                'series_one' => [
                    'label' => 'Поточний період',
                ],
                'series_two' => [
                    'label' => 'Попередній період',
                ],
                'yaxis' => [
                    'label' => 'Оборот :currency',
                ],
            ],
            'order_sales_chart' => [
                'heading' => 'Звіт по замовленнях/продажах',
                'series_one' => [
                    'label' => 'Замовлення',
                ],
                'series_two' => [
                    'label' => 'Дохід',
                ],
                'yaxis' => [
                    'series_one' => [
                        'label' => 'К-сть замовлень',
                    ],
                    'series_two' => [
                        'label' => 'Загальна сума',
                    ],
                ],
            ],
            'average_order_value' => [
                'heading' => 'Середній чек',
            ],
            'new_returning_customers' => [
                'heading' => 'Нові vs повторні клієнти',
                'series_one' => [
                    'label' => 'Нові клієнти',
                ],
                'series_two' => [
                    'label' => 'Повторні клієнти',
                ],
            ],
            'popular_products' => [
                'heading' => 'Бестселери (останні 12 місяців)',
                'description' => 'Ці показники базуються на кількості появ товару в замовленнях, а не на замовленій кількості.',
            ],
            'latest_orders' => [
                'heading' => 'Останні замовлення',
            ],
        ],
    ],
    'customer' => [
        'stats_overview' => [
            'total_orders' => [
                'label' => 'Усього замовлень',
            ],
            'avg_spend' => [
                'label' => 'Середні витрати',
            ],
            'total_spend' => [
                'label' => 'Загальні витрати',
            ],
        ],
    ],
    'variant_switcher' => [
        'label' => 'Перемкнути варіант',
        'table' => [
            'sku' => [
                'label' => 'SKU',
            ],
            'values' => [
                'label' => 'Значення',
            ],
        ],
    ],
];
