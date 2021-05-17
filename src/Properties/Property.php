<?php


namespace Pi\Notion\Properties;


use Pi\Notion\Query\MultiSelectFilter;

class Property
{


     public ?string $id;
     public string $type;
    public function __construct(string $id = null,string $type)
    {

        $this->id = $id ;
        $this->type = $type;

    }
}
