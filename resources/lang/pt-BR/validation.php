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

    'accepted'             => 'O campo ":attribute" deve ser aceito.',
    'active_url'           => 'O campo ":attribute" não possui uma URL válida.',
    'after'                => 'O campo ":attribute" deve ter uma data posterior à :date.',
    'alpha'                => 'O campo ":attribute" deve ter apenas letras.',
    'alpha_dash'           => 'O campo ":attribute" deve ter apenas letras, números e hífens.',
    'alpha_num'            => 'O campo ":attribute" deve ter apenas letras e números.',
    'array'                => 'O campo ":attribute" precisa ser um conjunto.',
    'before'               => 'O campo ":attribute" deve ter uma data anterior à :date.',
    'between'              => [
        'numeric' => 'O campo ":attribute" deve ter um valor entre :min e :max.',
        'file'    => 'O arquivo ":attribute" deve ter um tamanho entre :min e :max kilobytes.',
        'string'  => 'O campo ":attribute" deve ter entre :min e :max caracteres.',
        'array'   => 'O campo ":attribute" deve ter entre :min - :max itens.',
    ],
    'boolean'              => 'O campo ":attribute" deve ter o valor verdadeiro ou falso.',
    'confirmed'            => 'A confirmação para o campo ":attribute" não coincide.',
    'date'                 => 'O campo ":attribute" deve ter uma data válida.',
    'date_format'          => 'A data indicada para o campo ":attribute" não respeita o formato :format.',
    'different'            => 'Os campos ":attribute" e :other devem ter valores diferentes.',
    'digits'               => 'O campo ":attribute" deve ter :digits dígitos.',
    'digits_between'       => 'O campo ":attribute" deve ter entre :min e :max dígitos.',
    'email'                => 'O campo ":attribute" não possui um endereço de e-mail válido.',
    'exists'               => 'O valor selecionado para o campo ":attribute" é inválido.',
    'filled'               => 'O campo ":attribute" deve ser preenchido obrigatoriamente.',
    'image'                => 'O campo ":attribute" precisa ser uma imagem.',
    'in'                   => 'O campo ":attribute" não possui um valor válido.',
    'integer'              => 'O campo ":attribute" deve ter um número inteiro.',
    'ip'                   => 'O campo ":attribute" deve ter um IP válido.',
    'max'                  => [
        'numeric' => 'O campo ":attribute" não deve ter um valor superior a :max.',
        'file'    => 'O campo ":attribute" não deve ter um tamanho superior a :max kilobytes.',
        'string'  => 'O campo ":attribute" não deve ter mais de :max caracteres.',
        'array'   => 'O campo ":attribute" deve ter no máximo :max itens.',
    ],
    'mimes'                => 'O campo ":attribute" deve ter um arquivo do tipo: :values.',
    'min'                  => [
        'numeric' => 'O campo ":attribute" deve ter um valor superior ou igual a :min.',
        'file'    => 'O campo ":attribute" deve ter no mínimo :min kilobytes.',
        'string'  => 'O campo ":attribute" deve ter no mínimo :min caracteres.',
        'array'   => 'O campo ":attribute" deve ter no mínimo :min itens.',
    ],
    'not_in'               => 'O campo ":attribute" possui um valor inválido.',
    'numeric'              => 'O campo ":attribute" deve ter um valor numérico.',
    'regex'                => 'O formato do valor para o campo ":attribute" é inválido.',
    'required'             => 'É obrigatório o preenchimento do campo ":attribute".',
    'required_if'          => 'É obrigatório o preenchimento do campo ":attribute" quando o valor do campo :other é igual a :value.',
    'required_with'        => 'É obrigatório o preenchimento do campo ":attribute" quando :values está presente.',
    'required_with_all'    => 'É obrigatório o preenchimento do campo ":attribute" quando um dos :values está presente.',
    'required_without'     => 'É obrigatório o preenchimento do campo ":attribute" quando :values não está presente.',
    'required_without_all' => 'É obrigatório o preenchimento do campo ":attribute" quando nenhum dos :values estão presentes.',
    'same'                 => 'Os campos ":attribute" e :other devem ser iguais.',
    'size'                 => [
        'numeric' => 'O campo ":attribute" deve ter o valor :size.',
        'file'    => 'O campo ":attribute" deve ter o tamanho de :size kilobytes.',
        'string'  => 'O campo ":attribute" deve ter :size caracteres.',
        'array'   => 'O campo ":attribute" deve ter :size itens.',
    ],
    'string'               => 'O campo ":attribute" deve ser preenchido com letras.',
    'timezone'             => 'O campo ":attribute" deve ter um fuso horário válido.',
    'unique'               => 'O valor indicado para o campo ":attribute" está indisponível.',
    'url'                  => 'A URL do campo ":attribute" é inválida.',

    /*
    |--------------------------------------------------------------------------
    | Custom rules messages
    | -------------------------------------------------------------------------
    |
    | Messages used by custom rules.
    |
    */
    'recaptcha'            => 'Erro na validação do Captcha, por favor tente novamente.',

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

    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes'           => [
        'title'        => 'Título',
        'rating'       => 'Avaliação',
        'external_url' => 'Link IMDb/TMDb',
    ],

];
