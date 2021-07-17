<?php


namespace Pi\Notion\Properties;


use Pi\Notion\Query\MultiSelectFilter;
use Pi\Notion\Query\SelectFilter;
use Pi\Notion\Query\TitleFilter;

class Title extends Property
{

    public function __construct($name , $optionName = null, $color = null, $id=null)
    {
        parent::__construct(Property::TITLE,$name,$optionName, $id);
    }

    public function getValues(): array
    {
        return
            array
            (
                    array
                    (
                        'text' => array('content' => $this->getOptionName())
                    ) ?? null
            );
    }

}
