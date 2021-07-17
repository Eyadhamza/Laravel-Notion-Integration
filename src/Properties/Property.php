<?php


namespace Pi\Notion\Properties;


use Pi\Notion\Query\MultiSelectFilter;

class Property
{

    const TITLE = 'title';
    const MULTISELECT = 'multi_select';
    const SELECT = 'select';
    const PHONE= 'phone_number';
    const EMAIL = 'email';
    const URL_PROP = 'url';
    const CHECKBOX = 'checkbox';
    const NUMBER = 'number';
    const DATE = 'date';

    private string $type;
    private string $name;
    private  $optionName;
    private ?string $id;

    public function __construct(string $type, string $name, $optionName = null, string $id = null)
    {

        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->optionName = $optionName;
    }

    public function getValues()
    {
        return $this->optionName;
    }

    public static function addPropertiesToPage($page)
    {

       return $page->getProperties()->mapToAssoc(function ($property){

            return
                array(
                    $property->name, array($property->getType() => $property->getValues() ?? null)
                );
        });
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getOptionName(): string
    {
        return $this->optionName;
    }

}
