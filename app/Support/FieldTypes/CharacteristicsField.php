<?php

namespace App\Support\FieldTypes;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Lunar\Admin\Support\FieldTypes\BaseFieldType;

class CharacteristicsField extends BaseFieldType
{
    public static function getFilamentComponent($attribute): \Filament\Forms\Components\Component
    {
        return Repeater::make($attribute->handle)
            ->label($attribute->translate('name'))
            ->schema([
                TextInput::make('name')
                    ->label(__('messages.product.characteristic_name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('standard')
                    ->label(__('messages.product.standard_norm'))
                    ->maxLength(255),
                TextInput::make('actual')
                    ->label(__('messages.product.actual_values'))
                    ->required()
                    ->maxLength(255),
            ])
            ->collapsible()
            ->defaultItems(0)
            ->columnSpanFull()
            ->grid(3);
    }
}
