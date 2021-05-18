<?php /** @noinspection ALL */


namespace Pi\Notion\Query;


use Illuminate\Support\Collection;

class SelectFilter implements Filterable
{

    public function set($property): array
    {

       return [
           'property'=> $property->name,
                'select'=> is_null($property->option) ? $this->setFilterConditions($property) :['equals'=>$property->option]

       ];

    }
    public function setFilterConditions($property): array
    {
        return [
                'equals'=>$property->equals ,
                'does_not_equal'=>$property->notEqual,
                'is_not_empty'=>$property->isNotEmpty,
                'is_empty'=>$property->isEmpty
        ];
    }

}
