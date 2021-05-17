<?php


namespace Pi\Notion\Query;


use Illuminate\Support\Collection;

class SelectFilter implements Filterable
{

    public function set($property)
    {

       return [
           'property'=> $property->name,
                'select'=> is_null($property->option) ? $this->setFilterConditions($property) :['equals'=>$property->option]

       ];

    }
    public function setFilterConditions($property)
    {
        return [
                'equals'=>$property->equals ,
                'does_not_equal'=>$property->notEqual,
                'is_not_empty'=>$property->isNotEmpty,
                'is_empty'=>$property->isEmpty
        ];
    }

}
