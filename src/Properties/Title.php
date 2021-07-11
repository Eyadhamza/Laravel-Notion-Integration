<?php


namespace Pi\Notion\Properties;


use Pi\Notion\Query\MultiSelectFilter;
use Pi\Notion\Query\SelectFilter;
use Pi\Notion\Query\TitleFilter;

class Title extends Property
{


    // TODO CLASS OR CHANGE OR REMOVE

    public TitleFilter $filter;
    private $name;
    private $optionName;


    public function __construct($name , $optionName = null, $color = null, $id=null)
    {
        parent::__construct(Property::TITLE,$id);
        $this->name = $name;
        $this->optionName = $optionName;


    }

    public function setPropertyValues($name, $types): array
    {

    }



    public function getName()
    {
        return $this->name;
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

    public function getContent()
    {

    }

    public function getOptionName(): mixed
    {
        return $this->optionName;
    }


}
