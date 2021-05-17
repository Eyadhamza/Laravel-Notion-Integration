<?php


namespace Pi\Notion\Properties;


use Pi\Notion\Query\FilterSelect;

class SelectProperty
{
    public $key;
    public $value;
    public $filter;
    public function __construct($key,$value)
    {
        $this->key = $key;
        $this->value = $value;
        $this->filter = new FilterSelect();
    }

    public function set($key, $value): array
    {


        return [
            'property' => $key,

            'select' => $value,

        ];
    }


}
