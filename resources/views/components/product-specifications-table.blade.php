@props(['product'])

@php
    $locale = app()->getLocale();
    $complianceStandard = $product->compliance_standard ?? 'ДСТУ 2042-92';
    
    // Подготавливаем данные для таблицы
    $technicalSpecs = [
        [
            'name' => 'Масова доля загальної вологи (Wp)',
            'standard' => '20%',
            'actual' => $product->getAttributeValue('moisture_content') ? $product->getAttributeValue('moisture_content') . '%' : '19.1%'
        ],
        [
            'name' => 'Зольність (Ad)',
            'standard' => '23%',
            'actual' => $product->getAttributeValue('ash_content') ? $product->getAttributeValue('ash_content') . '%' : '18.3%'
        ],
        [
            'name' => 'Механічна міцність, %',
            'standard' => '96.6%',
            'actual' => $product->getAttributeValue('mechanical_strength') ? $product->getAttributeValue('mechanical_strength') . '%' : '96.6%'
        ],
        [
            'name' => 'Теплота згоряння Ккал/кг',
            'standard' => '>3500',
            'actual' => $product->getAttributeValue('heat_combustion_kcal') ?? '4155'
        ],
        [
            'name' => 'Теплота згоряння МДж/кг',
            'standard' => '>14.65',
            'actual' => $product->getAttributeValue('heat_combustion_mj') ?? '17.387'
        ],
        [
            'name' => 'Вміст сірки, %',
            'standard' => '-',
            'actual' => $product->getAttributeValue('sulfur_content') ? $product->getAttributeValue('sulfur_content') . '%' : '0.24%'
        ],
        [
            'name' => 'Забруднення радіонуклідами',
            'standard' => 'не нормується',
            'actual' => $product->getAttributeValue('radioactive_contamination') ?? 'не виявлено'
        ]
    ];
    
    // Если есть JSON спецификации, используем их
    if ($product->technical_specifications) {
        $customSpecs = is_string($product->technical_specifications) 
            ? json_decode($product->technical_specifications, true) 
            : $product->technical_specifications;
        
        if (is_array($customSpecs)) {
            $technicalSpecs = $customSpecs;
        }
    }
@endphp

<div class="technical-specifications-table w-full">
    <h3 class="text-xl font-bold text-black mb-4">Характеристики:</h3>
    
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <!-- Header -->
            <thead>
                <tr class="bg-gray-800 text-white">
                    <th class="px-4 py-3 text-left text-sm font-semibold">
                        Найменування показників
                    </th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">
                        Норма згідно з {{ $complianceStandard }}
                    </th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">
                        Отримані показники
                    </th>
                </tr>
            </thead>
            
            <!-- Body -->
            <tbody>
                @foreach($technicalSpecs as $spec)
                    <tr class="border-b border-gray-200 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                            {{ $spec['name'] ?? '' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ $spec['standard'] ?? '' }}
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                            {{ $spec['actual'] ?? '' }}
                        </td>
                    </tr>
                @endforeach
                
                @if(empty($technicalSpecs))
                    <tr>
                        <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                            Технічні характеристики не вказані
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
