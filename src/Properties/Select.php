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
    public function __construct($name , $option = null, $color = null,$id=null)
    {
        $this->type = 'select';
        $this->filter = new SelectFilter;

        parent::__construct($id, $this->type);

        $this->name = $name;
        $this->option = $option;
        $this->color = $color;

    }

    public function setPropertyValues($name, $types): array // for page creation
    {

    }


}
