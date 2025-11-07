<?php

namespace App\Filament\Resources\ProductCharacteristicResource\Pages;

use App\Filament\Resources\ProductCharacteristicResource;
use App\Models\ProductCharacteristic;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductCharacteristic extends EditRecord
{
    protected static string $resource = ProductCharacteristicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Загружаем все характеристики этого продукта
        $productId = $this->record->product_id;
        $characteristics = ProductCharacteristic::where('product_id', $productId)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($char) {
                return [
                    'id' => $char->id,
                    'name_en' => $char->name['en'] ?? '',
                    'name_uk' => $char->name['uk'] ?? '',
                    'standard_en' => $char->standard['en'] ?? '',
                    'standard_uk' => $char->standard['uk'] ?? '',
                    'actual_en' => $char->actual['en'] ?? '',
                    'actual_uk' => $char->actual['uk'] ?? '',
                ];
            })
            ->toArray();
        
        $data['product_id'] = $productId;
        $data['characteristics'] = $characteristics;
        
        return $data;
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Обрабатываем характеристики
        if (isset($data['characteristics']) && is_array($data['characteristics'])) {
            $productId = $data['product_id'];
            $existingIds = [];
            $sortOrder = 0;
            
            foreach ($data['characteristics'] as $characteristic) {
                $charData = [
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
                ];
                
                if (isset($characteristic['id']) && $characteristic['id']) {
                    // Обновляем существующую
                    ProductCharacteristic::where('id', $characteristic['id'])->update($charData);
                    $existingIds[] = $characteristic['id'];
                } else {
                    // Создаём новую
                    $newChar = ProductCharacteristic::create($charData);
                    $existingIds[] = $newChar->id;
                }
            }
            
            // Удаляем те что были убраны из repeater
            ProductCharacteristic::where('product_id', $productId)
                ->whereNotIn('id', $existingIds)
                ->delete();
        }
        
        // Возвращаем данные для основной записи (которую не сохраняем)
        return $this->record->toArray();
    }
    
    protected function afterSave(): void
    {
        // Редирект на список
        $this->redirect(static::getResource()::getUrl('index'));
    }
}
