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

    'accepted' => 'Поле :attribute повинно бути прийняте.',
    'accepted_if' => 'Поле :attribute повинно бути прийняте коли :other дорівнює :value.',
    'active_url' => 'Поле :attribute повинно містити правильний URL.',
    'after' => 'Поле :attribute повинно бути датою після :date.',
    'after_or_equal' => 'Поле :attribute повинно бути датою після або рівним :date.',
    'alpha' => 'Поле :attribute повинне містити лише букви.',
    'alpha_dash' => 'Поле :attribute повинно містити лише букви, цифри, дефіси та підкреслення.',
    'alpha_num' => 'Поле :attribute повинно містити лише букви та цифри.',
    'array' => 'Поле :attribute повинно бути масивом.',
    'ascii' => 'Поле :attribute повинно містити лише однобайтові буквено-цифрові символи та символи.',
    'before' => 'Поле :attribute повинно бути датою до :date.',
    'before_or_equal' => 'Поле :attribute повинно бути датою до або рівним :date.',
    'between' => [
        'array' => 'Поле :attribute повинне містити від :min до :max елементів.',
        'file' => 'Поле :attribute повинно бути від :min до :max кілобайт.',
        'numeric' => 'Поле :attribute повинно бути від :min до :max.',
        'string' => 'Поле :attribute повинно бути від :min до :max символів.',
    ],
    'boolean' => 'Поле :attribute повинно бути true чи false.',
    'confirmed' => 'Поле :attribute не співпадає з підтвердженням.',
    'current_password' => 'Неправильний пароль.',
    'date' => 'Поле :attribute повинно бути коректною датою.',
    'date_equals' => 'Поле :attribute повинно дорівнювати даті :date.',
    'date_format' => 'Поле :attribute повинно відповідати формату :format.',
    'decimal' => 'Поле :attribute повинно мати :decimal десяткові знаки.',
    'declined' => 'Поле :attribute повинно бути відхилене.',
    'declined_if' => 'Поле :attribute повинно бути відхилене коли має місце :other дорівнює :value.',
    'different' => 'Поле :attribute та :other повинні бути різними.',
    'digits' => 'Поле :attribute повинно бути із :digits цифр.',
    'digits_between' => 'Поле :attribute повинно бути від :min до :max цифр.',
    'dimensions' => 'Поле :attribute має неприпустимі розміри зображення.',
    'distinct' => 'Поле :attribute містить повторювані значення.',
    'doesnt_end_with' => 'Поле :attribute не повинно закінчуватися на наступні значення: :values.',
    'doesnt_start_with' => 'Поле :attribute не повинно починатися на наступні значення: :values.',
    'email' => 'Поле :attribute має бути дійсною адресою електронної пошти.',
    'ends_with' => 'Поле :attribute має закінчуватися одним з наступних: :values.',
    'enum' => 'Вибраний :attribute недійсний.',
    'exists' => 'Вибраний :attribute недійсний.',
    'file' => 'Поле :attribute має бути файлом.',
    'filled' => 'Поле :attribute має мати значення.',
    'gt' => [
        'array' => 'Поле :attribute має мати більше ніж :value елементів.',
        'file' => 'Поле :attribute має бути більше ніж :value кілобайт.',
        'numeric' => 'Поле :attribute має бути більше ніж :value.',
        'string' => 'Поле :attribute має бути більше ніж :value символів.',
    ],
    'gte' => [
        'array' => 'Поле :attribute має мати :value елементів або більше.',
        'file' => 'Поле :attribute має бути більше або рівне :value кілобайтам.',
        'numeric' => 'Поле :attribute має бути більше або рівне :value.',
        'string' => 'Поле :attribute має бути більше або рівне :value символам.',
    ],
    'image' => 'Поле :attribute має бути зображенням.',
    'in' => 'Вибраний :attribute недійсний.',
    'in_array' => 'Поле :attribute має існувати в :other.',
    'integer' => 'Поле :attribute має бути цілим числом.',
    'ip' => 'Поле :attribute має бути дійсною IP-адресою.',
    'ipv4' => 'Поле :attribute має бути дійсною IPv4-адресою.',
    'ipv6' => ':attribute :attribute має бути дійсною IPv6 адресою.',
    'json' => 'Поле :attribute має бути коректним JSON-рядком.',
    'lowercase' => 'Поле :attribute має бути нижнього регістру.',
    'lt' => [
        'array' => 'Поле :attribute повинно мати менше елементів, ніж :value.',
        'file' => 'Поле :attribute має бути меншим за :value кілобайтів.',
        'numeric' => 'Поле :attribute має бути меншим за :value.',
        'string' => 'Поле :attribute має бути меншим за :value символів.',
    ],
    'lte' => [
        'array' => 'Поле :attribute не повинно містити більше елементів :value.',
        'file' => 'Поле :attribute має бути менше або дорівнювати :value кілобайт.',
        'numeric' => 'Поле :attribute повинно бути менше або дорівнювати :value.',
        'string' => 'Поле :attribute повинно бути менше або дорівнювати :value символів.',
    ],
    'mac_address' => 'Поле :attribute має бути дійсною MAC-адресою.',
    'max' => [
        'array' => 'Поле :attribute не повинно містити більше ніж :max елементів.',
        'file' => 'Поле :attribute не повинно мати більше ніж :max кілобайт.',
        'numeric' => 'Поле :attribute не повинно бути більшим за :max.',
        'string' => 'Поле :attribute не повинно перевищувати :max символів.',
    ],
    'max_digits' => 'Поле :attribute не повинно містити більше :max цифр.',
    'mimes' => 'Поле :attribute має бути файлом типу: :values.',
    'mimetypes' => 'Поле :attribute має бути файлом типу: :values.',
    'min' => [
        'array' => 'Поле :attribute повинно містити принаймні :min елементів.',
        'file' => 'Поле :attribute повинно бути не менше :min кілобайт.',
        'numeric' => 'Поле :attribute повинно бути не менше :min.',
        'string' => 'Поле :attribute повинно містити принаймні :min символів.',
    ],
    'min_digits' => 'Поле :attribute повинно містити принаймні :min цифр.',
    'missing' => 'Поле :attribute повинно бути відсутнім.',
    'missing_if' => 'Поле :attribute повинно бути відсутнім, коли :other має значення :value.',
    'missing_unless' => 'Поле :attribute повинно бути відсутнім, якщо :other не має значення :value.',
    'missing_with' => 'Поле :attribute повинно бути відсутнім, коли присутнє значення :values.',
    'missing_with_all' => 'Поле :attribute повинно бути відсутнім, коли присутні значення :values.',
    'multiple_of' => 'Поле :attribute повинно бути кратним :value.',
    'not_in' => 'Вибране значення :attribute є недійсним.',
    'not_regex' => 'Формат поля :attribute є недійсним.',
    'numeric' => 'Поле :attribute повинно бути числом.',
    'password' => [
        'letters' => 'Поле :attribute повинно містити принаймні одну літеру.',
        'mixed' => 'Поле :attribute повинно містити принаймні одну велику і одну малу літеру.',
        'numbers' => 'Поле :attribute повинно містити принаймні одне число.',
        'symbols' => 'Поле :attribute повинно містити принаймні один символ.',
        'uncompromised' => 'Вказане значення :attribute вже з\'являлося у витоку даних. Будь ласка, виберіть інше значення для :attribute.',
    ],
    'present' => 'Поле :attribute повинно бути присутнім.',
    'prohibited' => 'Поле :attribute заборонено.',
    'prohibited_if' => 'Поле :attribute заборонено, коли :other має значення :value.',
    'prohibited_unless' => 'Поле :attribute заборонено, якщо :other не має значення :values.',
    'prohibits' => 'Поле :attribute забороняє присутність :other.',
    'regex' => 'Формат поля :attribute є недійсним.',
    'required' => 'Поле :attribute є обов\'язковим.',
    'required_array_keys' => 'Поле :attribute повинно містити елементи для: :values.',
    'required_if' => 'Поле :attribute є обов\'язковим, коли :other має значення :value.',
    'required_if_accepted' => 'Поле :attribute є обов\'язковим, коли :other прийнято.',
    'required_unless' => 'Поле :attribute є обов\'язковим, якщо :other не має значення :values.',
    'required_with' => 'Поле :attribute є обов\'язковим, коли присутнє значення :values.',
    'required_with_all' => 'Поле :attribute є обов\'язковим, коли присутні значення :values.',
    'required_without' => 'Поле :attribute є обов\'язковим, коли значення :values відсутні.',
    'required_without_all' => 'Поле :attribute є обов\'язковим, коли відсутні всі значення :values.',
    'same' => 'Поле :attribute повинно співпадати з :other.',
    'size' => [
        'array' => 'Поле :attribute повинно містити :size елементів.',
        'file' => 'Поле :attribute повинно бути розміром :size кілобайт.',
        'numeric' => 'Поле :attribute повинно бути числом розміром :size.',
        'string' => 'Поле :attribute повинно бути рядком довжиною :size символів.',
    ],
    'starts_with' => 'Поле :attribute повинно починатися з одного з наступних значень: :values.',
    'string' => 'Поле :attribute повинно бути рядком.',
    'timezone' => 'Поле :attribute повинно бути дійсною часовою зоною.',
    'unique' => 'Поле :attribute вже зайняте.',
    'uploaded' => 'Помилка завантаження поля :attribute.',
    'uppercase' => 'Поле :attribute повинно містити тільки великі літери.',
    'url' => 'Поле :attribute повинно бути дійсним URL.',
    'ulid' => 'Поле :attribute повинно бути дійсним ULID.',
    'uuid' => 'Поле :attribute повинно бути дійсним UUID.',
    'money' => [
        'not_enough_funds' => 'Недостатньо коштів на рахунку.',
    ],

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
            'rule-name' => 'custom-message',
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
