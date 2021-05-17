<?php


namespace Pi\Notion\Query;


class SelectFilter implements Filterable
{

    public function set($property)
    {

        $propertyConditions = collect($this->setFilterConditions($property));

       return [
           'property'=> $property->name,
                'select'=>
                    $propertyConditions->map(function ($condition){
                    return $condition;
                })





       ];

    }
    public function setFilterConditions($property)
    {
        dd($property);
        return ;
    }

}
