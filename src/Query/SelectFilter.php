<?php


namespace Pi\Notion\Query;


class SelectFilter implements Filterable
{

    public function set($property)
    {

       return [
           'property'=> $property->name,
                'select'=> [
                    'equals' =>$property->option
                ]
       ];

    }
}
