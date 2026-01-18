<?php

namespace App\Support\Forms\Components;

use Filament\Forms\Components\Textarea;
use Lunar\Admin\Support\Forms\Components\TranslatedText;

class TranslatedTextarea extends TranslatedText
{
    public function prepareChildComponents()
    {
        $this->components = collect(
            $this->getLanguages()->map(function ($lang) {
                $component = Textarea::make($lang->code)
                    ->statePath($lang->code)
                    ->rows(4)
                    ->autosize()
                    ->hiddenLabel();

                if (method_exists($component, 'regex')) {
                    $component->regex($this->regexPattern);
                }

                if (method_exists($component, 'minLength')) {
                    $component->minLength($this->minLength);
                }

                if (method_exists($component, 'maxLength')) {
                    $component->maxLength($this->maxLength);
                }

                if (! empty($this->extraInputAttributes)) {
                    $component->extraInputAttributes($this->extraInputAttributes, $this->mergeExtraInputAttributes);
                }

                return $component;
            })
        );
    }
}
