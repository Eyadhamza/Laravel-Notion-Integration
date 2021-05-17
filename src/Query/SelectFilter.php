<?php


namespace Pi\Notion\Query;


class SelectFilter implements Filterable
{

    public function set($property)
    {

       return [
           'property'=> $property->n,
                'select'=> [
                    'equals' =>$property->value
                ]
       ];

    }
}
