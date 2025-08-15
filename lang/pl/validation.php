<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Поле :attribute має бути прийняте.',
    'accepted_if' => 'Поле :attribute має бути прийняте, коли :other має значення :value.',
    'active_url' => 'Поле :attribute не є правильною URL-адресою.',
    'after' => 'Поле :attribute має бути датою пізнішою за :date.',
    'after_or_equal' => 'Поле :attribute має бути датою не раніше ніж :date.',
    'alpha' => 'Поле :attribute може містити лише літери.',
    'alpha_dash' => 'Поле :attribute може містити лише літери, цифри, дефіси та підкреслення.',
    'alpha_num' => 'Поле :attribute може містити лише літери та цифри.',
    'array' => 'Поле :attribute має бути масивом.',
    'ascii' => 'Поле :attribute може містити лише однобайтові алфавітно-цифрові символи.',
    'before' => 'Поле :attribute має бути датою раніше ніж :date.',
    'before_or_equal' => 'Поле :attribute має бути датою не пізніше ніж :date.',
    'between' => [
        'array' => 'Поле :attribute має містити від :min до :max елементів.',
        'file' => 'Поле :attribute має бути від :min до :max кілобайт.',
        'numeric' => 'Поле :attribute має бути від :min до :max.',
        'string' => 'Поле :attribute має містити від :min до :max символів.',
    ],
    'boolean' => 'Поле :attribute має мати значення істина або хибність.',
    'confirmed' => 'Підтвердження поля :attribute не збігається.',
    'current_password' => 'Пароль неправильний.',
    'date' => 'Поле :attribute не є правильною датою.',
    'date_equals' => 'Поле :attribute має бути датою, що дорівнює :date.',
    'date_format' => 'Поле :attribute не відповідає формату :format.',
    'decimal' => 'Поле :attribute має мати :decimal десяткових знаків.',
    'declined' => 'Поле :attribute має бути відхилено.',
    'declined_if' => 'Поле :attribute має бути відхилено, коли :other має значення :value.',
    'different' => 'Поле :attribute і :other мають відрізнятися.',
    'digits' => 'Поле :attribute має містити :digits цифр.',
    'digits_between' => 'Поле :attribute має містити від :min до :max цифр.',
    'dimensions' => 'Поле :attribute має неправильні розміри зображення.',
    'distinct' => 'Поле :attribute має дубльоване значення.',
    'doesnt_end_with' => 'Поле :attribute не може закінчуватися одним з наступних: :values.',
    'doesnt_start_with' => 'Поле :attribute не може починатися з одного з наступних: :values.',
    'email' => 'Поле :attribute має бути правильною електронною адресою.',
    'ends_with' => 'Поле :attribute має закінчуватися одним з наступних: :values.',
    'enum' => 'Обране :attribute неправильне.',
    'exists' => 'Обране :attribute неправильне.',
    'file' => 'Поле :attribute має бути файлом.',
    'filled' => 'Поле :attribute має мати значення.',
    'gt' => [
        'array' => 'Поле :attribute має містити більше ніж :value елементів.',
        'file' => 'Поле :attribute має бути більше ніж :value кілобайт.',
        'numeric' => 'Поле :attribute має бути більше ніж :value.',
        'string' => 'Поле :attribute має містити більше ніж :value символів.',
    ],
    'gte' => [
        'array' => 'Поле :attribute має містити :value елементів або більше.',
        'file' => 'Поле :attribute має бути більше або дорівнювати :value кілобайт.',
        'numeric' => 'Поле :attribute має бути більше або дорівнювати :value.',
        'string' => 'Поле :attribute має містити :value символів або більше.',
    ],
    'image' => 'Поле :attribute має бути зображенням.',
    'in' => 'Обране :attribute неправильне.',
    'in_array' => 'Поле :attribute не існує в :other.',
    'integer' => 'Поле :attribute має бути цілим числом.',
    'ip' => 'Поле :attribute має бути правильною IP-адресою.',
    'ipv4' => 'Поле :attribute має бути правильною IPv4-адресою.',
    'ipv6' => 'Поле :attribute має бути правильною IPv6-адресою.',
    'json' => 'Поле :attribute має бути правильним JSON-рядком.',
    'lowercase' => 'Поле :attribute має бути написане малими літерами.',
    'lt' => [
        'array' => 'Поле :attribute має містити менше ніж :value елементів.',
        'file' => 'Поле :attribute має бути менше ніж :value кілобайт.',
        'numeric' => 'Поле :attribute має бути менше ніж :value.',
        'string' => 'Поле :attribute має містити менше ніж :value символів.',
    ],
    'lte' => [
        'array' => 'Поле :attribute не може містити більше ніж :value елементів.',
        'file' => 'Поле :attribute має бути менше або дорівнювати :value кілобайт.',
        'numeric' => 'Поле :attribute має бути менше або дорівнювати :value.',
        'string' => 'Поле :attribute має містити :value символів або менше.',
    ],
    'mac_address' => 'Поле :attribute має бути правильною MAC-адресою.',
    'max' => [
        'array' => 'Поле :attribute не може містити більше ніж :max елементів.',
        'file' => 'Поле :attribute не може бути більше ніж :max кілобайт.',
        'numeric' => 'Поле :attribute не може бути більше ніж :max.',
        'string' => 'Поле :attribute не може містити більше ніж :max символів.',
    ],
    'max_digits' => 'Поле :attribute не може містити більше ніж :max цифр.',
    'mimes' => 'Поле :attribute має бути файлом типу: :values.',
    'mimetypes' => 'Поле :attribute має бути файлом типу: :values.',
    'min' => [
        'array' => 'Поле :attribute має містити принаймні :min елементів.',
        'file' => 'Поле :attribute має бути принаймні :min кілобайт.',
        'numeric' => 'Поле :attribute має бути принаймні :min.',
        'string' => 'Поле :attribute має містити принаймні :min символів.',
    ],
    'min_digits' => 'Поле :attribute має містити принаймні :min цифр.',
    'multiple_of' => 'Поле :attribute має бути кратним :value.',
    'not_in' => 'Обране :attribute неправильне.',
    'not_regex' => 'Формат поля :attribute неправильний.',
    'numeric' => 'Поле :attribute має бути числом.',
    'password' => [
        'letters' => 'Поле :attribute має містити принаймні одну літеру.',
        'mixed' => 'Поле :attribute має містити принаймні одну велику та одну малу літеру.',
        'numbers' => 'Поле :attribute має містити принаймні одну цифру.',
        'symbols' => 'Поле :attribute має містити принаймні один символ.',
        'uncompromised' => 'Дані :attribute з\'явилися в витоку даних. Оберіть інше :attribute.',
    ],
    'present' => 'Поле :attribute має бути присутнє.',
    'prohibited' => 'Поле :attribute заборонене.',
    'prohibited_if' => 'Поле :attribute заборонене, коли :other має значення :value.',
    'prohibited_unless' => 'Поле :attribute заборонене, якщо :other не знаходиться в :values.',
    'prohibits' => 'Поле :attribute забороняє присутність :other.',
    'regex' => 'Формат поля :attribute неправильний.',
    'required' => 'Поле :attribute є обов\'язковим.',
    'required_array_keys' => 'Поле :attribute має містити записи для: :values.',
    'required_if' => 'Поле :attribute є обов\'язковим, коли :other має значення :value.',
    'required_if_accepted' => 'Поле :attribute є обов\'язковим, коли :other прийнято.',
    'required_unless' => 'Поле :attribute є обов\'язковим, якщо :other не знаходиться в :values.',
    'required_with' => 'Поле :attribute є обов\'язковим, коли :values присутнє.',
    'required_with_all' => 'Поле :attribute є обов\'язковим, коли :values присутні.',
    'required_without' => 'Поле :attribute є обов\'язковим, коли :values не присутнє.',
    'required_without_all' => 'Поле :attribute є обов\'язковим, коли жодне з :values не присутнє.',
    'same' => 'Поле :attribute і :other мають збігатися.',
    'size' => [
        'array' => 'Поле :attribute має містити :size елементів.',
        'file' => 'Поле :attribute має бути :size кілобайт.',
        'numeric' => 'Поле :attribute має бути :size.',
        'string' => 'Поле :attribute має містити :size символів.',
    ],
    'starts_with' => 'Поле :attribute має починатися з одного з наступних: :values.',
    'string' => 'Поле :attribute має бути рядком.',
    'timezone' => 'Поле :attribute має бути правильним часовим поясом.',
    'unique' => 'Поле :attribute вже зайняте.',
    'uploaded' => 'Не вдалося завантажити файл :attribute.',
    'uppercase' => 'Поле :attribute має бути написане великими літерами.',
    'url' => 'Поле :attribute має бути правильною URL-адресою.',
    'ulid' => 'Поле :attribute має бути правильним ULID.',
    'uuid' => 'Поле :attribute має бути правильним UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'спеціальне-повідомлення',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
