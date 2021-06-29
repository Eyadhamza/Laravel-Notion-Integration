<?php


namespace Pi\Notion\Properties;


use Pi\Notion\Query\MultiSelectFilter;

abstract class Property
{


     public ?string $id;
     public string $type;
    public function __construct(string $type,string $id = null)
    {

        $this->id = $id ;
        $this->type = $type;

    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    abstract function values();
}
