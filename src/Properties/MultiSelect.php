<?php


namespace Pi\Notion\Properties;


use Pi\Notion\Query\FilterSelect;

class MultiSelect
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
