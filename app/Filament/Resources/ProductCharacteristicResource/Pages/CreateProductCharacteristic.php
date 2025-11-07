<?php

namespace App\Filament\Resources\ProductCharacteristicResource\Pages;

use App\Filament\Resources\ProductCharacteristicResource;
use App\Models\ProductCharacteristic;
use Filament\Resources\Pages\CreateRecord;

class CreateProductCharacteristic extends CreateRecord
{
    protected static string $resource = ProductCharacteristicResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Если есть repeater данные, обрабатываем их
        if (isset($data['characteristics']) && is_array($data['characteristics'])) {
            $productId = $data['product_id'];
            $sortOrder = 0;
            
            foreach ($data['characteristics'] as $characteristic) {
                ProductCharacteristic::create([
                    'product_id' => $productId,
                    'name' => [
                        'en' => $characteristic['name_en'],
                        'uk' => $characteristic['name_uk'],
                    ],
                    'standard' => [
                        'en' => $characteristic['standard_en'] ?? '',
                        'uk' => $characteristic['standard_uk'] ?? '',
                    ],
                    'actual' => [
                        'en' => $characteristic['actual_en'],
                        'uk' => $characteristic['actual_uk'],
                    ],
                    'sort_order' => $sortOrder++,
                ]);
            }
            
            // Возвращаем пустой массив чтобы не создавать основную запись
            return [];
        }
        
        return $data;
    }
    
    protected function afterCreate(): void
    {
        // Редирект на список после создания
        $this->redirect(static::getResource()::getUrl('index'));
    }
    
    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Если данные пустые (уже обработаны в mutate), создаем пустую запись
        // которая не будет сохранена
        if (empty($data)) {
            return new ProductCharacteristic();
        }
        
        return static::getModel()::create($data);
    }
}
