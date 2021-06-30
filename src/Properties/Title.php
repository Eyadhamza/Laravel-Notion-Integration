<?php


namespace Pi\Notion\Properties;


use Pi\Notion\Query\MultiSelectFilter;
use Pi\Notion\Query\SelectFilter;
use Pi\Notion\Query\TitleFilter;

class Title extends Property
{


    public TitleFilter $filter;
    private $name;
    private $optionName;


    public function __construct($name , $optionName = null, $color = null, $id=null)
    {

        $this->type = PropertyType::TITLE;
        $this->filter = new TitleFilter();

        parent::__construct($this->type,$id);

        $this->name = $name;

        $this->optionName = $optionName;


    }

    public function setPropertyValues($name, $types): array // for page creation
    {

    }



    public function getName()
    {
        return $this->name;
    }

    public function getValues(): array // for page creation
    {
        return
            array(
                    array(
                        'text' => array('content' => $this->getOptionName())
                    ) ?? null
        );
    }

    public function getContent()
    {

    }

    /**
     * @return mixed|null
     */
    public function getOptionName(): mixed
    {
        return $this->optionName;
    }


}
