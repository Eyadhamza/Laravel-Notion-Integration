<?php


namespace Pi\Notion\Query;


class FilterSelect implements Filterable
{

    public function set($property)
    {
       return [
           'property'=> $property['property'],
                'select'=> [
                    'equals' =>$property['select']
                ]
       ];

    }
}
