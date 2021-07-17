<?php


namespace Pi\Notion\Properties;


use Pi\Notion\Query\MultiSelectFilter;
use Pi\Notion\Query\SelectFilter;

class Select extends Property
{

    private $color;

    public function __construct($name, $optionName = null, $color = null, $id=null)
    {

        parent::__construct(Property::SELECT, $name, $optionName, $id);
        $this->color = $color;

    }

    public function getValues(): array
    {
        return
            array(
                'name'=> $this->getOptionName() ?? null,
                'color'=>$this->color ?? null
        );
    }

}
