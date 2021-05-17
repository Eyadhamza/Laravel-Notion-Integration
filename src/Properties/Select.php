<?php


namespace Pi\Notion\Properties;


use Pi\Notion\Query\FilterMultiSelect;

class Select
{
    public $key;
    public $value;
    public $filter;
    public function __construct($key,$value)
    {
        $this->key = $key;
        $this->value = $value;
        $this->filter = new FilterMultiSelect();
    }

    public function setPropertyValues($key, $values): array // for page creation
    {

    }


}
