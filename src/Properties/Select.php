<?php


namespace Pi\Notion\Properties;


use Pi\Notion\Query\MultiSelectFilter;
use Pi\Notion\Query\SelectFilter;

class Select extends Property
{

    private $optionName;
    private $color;
    private $name;



    public function __construct($name , $optionName = null, $color = null, $id=null)
    {

        parent::__construct(Property::SELECT,$id);
        $this->name = $name;
        $this->optionName = $optionName;
        $this->color = $color;


    }

    public function getValues(): array
    {
        return
            array(
                'name'=> $this->optionName ?? null,
                'color'=>$this->color ?? null
        );
    }


    public function getName()
    {
        return $this->name;
    }


}
