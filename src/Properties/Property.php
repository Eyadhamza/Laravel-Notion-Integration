<?php


namespace Pi\Notion\Properties;


use Pi\Notion\Query\MultiSelectFilter;

abstract class Property
{
    const TITLE = 'title';
    const MULTISELECT = 'multi_select';
    const SELECT = 'select';


    private ?string $id;
    private string $type;


    public function __construct(string $type,string $id = null)
    {

        $this->id = $id ;
        $this->type = $type;

    }

    abstract function getValues();

    public static function addPropertiesToPage($page)
    {

       return $page->getProperties()->mapToAssoc(function ($property){
            return
                array(
                    $property->getName(), array($property->getType() => $property->getValues() ?? null)
                );
        });
    }

    public function getType(): string
    {
        return $this->type;
    }

}
