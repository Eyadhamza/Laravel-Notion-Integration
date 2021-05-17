<?php


namespace Pi\Notion\Properties;


use Pi\Notion\Query\MultiSelectFilter;
use Pi\Notion\Query\SelectFilter;

class MultiSelect extends Property
{

    public MultiSelectFilter $filter;
    public $option;

    public $color;

    public $name;
    public function __construct($name , $option = null, $color = null,$id=null)
    {
        $this->type = 'multi_select';
        $this->filter = new MultiSelectFilter;

        parent::__construct($this->type,$id);

        $this->name = $name;
        $this->option = $option;
        $this->color = $color;

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
