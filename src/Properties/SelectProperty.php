<?php


namespace Pi\Notion\Properties;


class SelectProperty
{
    private $key;
    private $value;

    public function __construct($key, $value)
    {

        $this->key = $key;
        $this->value = $value;


    }

    public static function set($key, $value): array
    {
        return [
            'property' => $key,

            'select' => $value,

        ];
    }


}
