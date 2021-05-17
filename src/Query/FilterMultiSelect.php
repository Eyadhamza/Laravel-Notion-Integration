<?php


namespace Pi\Notion\Query;


class FilterMultiSelect implements Filterable
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
