<?php /** @noinspection ALL */


namespace Pi\Notion\Query;


use Illuminate\Support\Collection;

class SelectFilter implements Filterable
{

    public function set($filter): array
    {

       return [
           'property'=> $filter->name,
                'select'=> is_null($filter->option) ? $this->setFilterConditions($filter) :['equals'=>$filter->option]

       ];

    }
    public function setFilterConditions($conditions): array
    {
        return [
                'equals'=>$conditions->equals ,
                'does_not_equal'=>$conditions->notEqual,
                'is_not_empty'=>$conditions->isNotEmpty,
                'is_empty'=>$conditions->isEmpty
        ];
    }

}
