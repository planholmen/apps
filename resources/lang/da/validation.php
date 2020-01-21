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

    'file' => ':Attribute skal være en fil.',
    'gt' => [
        'numeric' => ':Attribute skal være større end :value.',
    ],
    'mimes' => ':Attribute skal være en fil af en af typerne: :values.',
    'min' => [
        'string' => ':Attribute skal have en længde på mindst :min bogstaver.',
    ],
    'numeric' => ':Attribute skal være et tal.',
    'required' => ':Attribute er påkrævet.',

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

    'custom' => [],

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

    'attributes' => [
        'department' => 'udvalg',
        'activity' => 'aktivitet',
        'amount' => 'beløb',
        'file' => 'fil',
    ],

];
