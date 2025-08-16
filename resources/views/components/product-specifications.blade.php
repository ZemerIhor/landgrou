@props(['product'])

@php
    $locale = app()->getLocale();
    $complianceStandard = $product->compliance_standard ?? 'ДСТУ 2042-92 «Брикети торфові для комунально- побутових»';
@endphp

<div class="product-specifications bg-gray-50 p-6 rounded-lg">
    <!-- Compliance Note -->
    <div class="mb-6">
        <p class="text-sm text-gray-700 mb-4">
            Брикет відповідає вимогам {{ $complianceStandard }}.
        </p>
    </div>

    <!-- Main Specifications List -->
    <div class="specifications-list space-y-3">
        @php
            $mainSpecs = [
                'calorific_value' => ['label' => 'Калорійність', 'unit' => 'ккал/кг', 'prefix' => 'до '],
                'moisture_content' => ['label' => 'Масова доля загальної вологи', 'unit' => '%', 'prefix' => 'до '],
                'mechanical_strength' => ['label' => 'Механічна міцність', 'unit' => '%', 'prefix' => ''],
                'ash_content' => ['label' => 'Зольність', 'unit' => '%', 'prefix' => ''],
                'dimensions' => ['label' => 'Розміри', 'unit' => 'мм', 'prefix' => ''],
                'raw_material' => ['label' => 'Сировина', 'unit' => '', 'prefix' => ''],
            ];
        @endphp

        @foreach($mainSpecs as $handle => $spec)
            @php
                $value = $product->getAttributeValue($handle);
            @endphp
            @if($value)
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-sm font-medium text-gray-600">{{ $spec['label'] }}</span>
                    <span class="text-sm font-semibold text-gray-800">
                        {{ $spec['prefix'] }}{{ $value }}@if($spec['unit']) {{ $spec['unit'] }}@endif
                    </span>
                </div>
            @endif
        @endforeach

        <!-- Packaging Type -->
        @if($product->packaging_type)
            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                <span class="text-sm font-medium text-gray-600">Вид пакування</span>
                <span class="text-sm font-semibold text-gray-800">{{ $product->packaging_type }}</span>
            </div>
        @endif
    </div>
</div>
