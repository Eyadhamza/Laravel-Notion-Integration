<?php


namespace Pi\Notion\Query;


class MultiSelectFilter implements Filterable
{

    public function set($filter): array
    {

        return [
            'property'=> $filter->getName(),
            'multi_select'=> is_null($filter->getOption()) ? $this->setFilterConditions($filter) :['contains'=>$filter->getOption()]

        ];

    }
    public function setFilterConditions($conditions): array
    {
        return [
            'contains' => $conditions->getContains() ,
            'does_not_contain' => $conditions->getNotContain(),
            'is_not_empty' => $conditions->getIsNotEmpty(),
            'is_empty' => $conditions->getIsEmpty()
        ];
    }
}
