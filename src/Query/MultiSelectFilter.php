<?php


namespace Pi\Notion\Query;


class MultiSelectFilter implements Filterable
{

    public function set($property)
    {


       return [

           'property'=> $property->key,
                'multi_select'=> [
                    'contains' =>$property->value
                ],

       ];

    }
}
