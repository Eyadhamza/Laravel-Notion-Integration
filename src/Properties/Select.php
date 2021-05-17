<?php


namespace Pi\Notion\Properties;


use Pi\Notion\Query\MultiSelectFilter;
use Pi\Notion\Query\SelectFilter;

class Select extends Property
{

    public SelectFilter $filter;
    public $option;

    public $color;

    public $name;

    public $equals;

    public $notEqual;
    public $isNotEmpty;

    public $isEmpty;

    public function __construct($name , $option = null, $color = null,$id=null)
    {
        $this->type = 'select';
        $this->filter = new SelectFilter;

        parent::__construct($this->type,$id);

        $this->name = $name;
        $this->option = $option;
        $this->color = $color;


    }

    public function setPropertyValues($name, $types): array // for page creation
    {

    }


    public function equals($option)
    {
         $this->equals = $option;

         return $this;
    }

    public function notEqual($option)
    {
        $this->notEqual = $option;


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

}
