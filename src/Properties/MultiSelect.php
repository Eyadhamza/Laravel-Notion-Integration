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
    public $contains;
    public $notContain;
    public  $isNotEmpty;
    public  $isEmpty;

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


    public function contains($option)
    {
        $this->contains = $option;

        return $this;
    }

    public function notContain($option)
    {
        $this->notContain = $option;


        return $this;
    }

    public function isNotEmpty()
    {
        $this->isNotEmpty = true;


        return $this;
    }

    public function isEmpty()
    {
        $this->isEmpty = true;


        return $this;
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
