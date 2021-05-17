<?php


namespace Pi\Notion\Query;


class MultiSelectFilter implements Filterable
{

    public function set($property)
    {


       return [

           'property'=> $property->name,
                'multi_select'=> [
                    'contains' =>$property->option
                ],

       ];

    }
}
