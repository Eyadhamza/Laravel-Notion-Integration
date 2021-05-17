<?php


namespace Pi\Notion\Properties;


use Pi\Notion\Query\MultiSelectFilter;

class MultiSelect
{
    public string $key;
    public $value;
    public MultiSelectFilter $filter;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
        $this->filter = new MultiSelectFilter();
    }

    public function setPropertyValues($key, $values): array // for page creation
    {

    }



    //"Tags": {
    //    "multi_select": [
    //      {
    //        "name": "B"
    //      },
    //      {
    //        "name": "C"
    //      }
    //    ]
    //  }

}
