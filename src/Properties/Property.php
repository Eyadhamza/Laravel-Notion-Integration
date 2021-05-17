<?php


namespace Pi\Notion\Properties;


use Pi\Notion\Query\MultiSelectFilter;

class Property
{


     public ?string $id;
     public string $type;
    public function __construct(string $type,string $id = null)
    {

        $this->id = $id ;
        $this->type = $type;

    }


}
