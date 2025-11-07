<?php

namespace App\Support\FieldTypes;

use Filament\Forms\Components\KeyValue;
use Lunar\Admin\Support\FieldTypes\BaseFieldType;

class ShortSpecsField extends BaseFieldType
{
    public static function getFilamentComponent($attribute): \Filament\Forms\Components\Component
    {
        return KeyValue::make($attribute->handle)
            ->label($attribute->translate('name'))
            ->keyLabel(__('messages.product.spec_name'))
            ->valueLabel(__('messages.product.spec_value'))
            ->columnSpanFull()
            ->reorderable();
    }
}
