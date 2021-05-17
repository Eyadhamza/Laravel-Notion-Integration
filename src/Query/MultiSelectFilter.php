<?php


namespace Pi\Notion\Query;


class MultiSelectFilter implements Filterable
{

    public function set($property)
    {

        return [
            'property'=> $property->name,
            'multi_select'=> is_null($property->option) ? $this->setFilterConditions($property) :['contains'=>$property->option]

        ];

    }
    public function setFilterConditions($property)
    {
        return [
            'contains' => $property->contains ,
            'does_not_contain' => $property->notContain,
            'is_not_empty' => $property->isNotEmpty,
            'is_empty' => $property->isEmpty
        ];
    }
}
