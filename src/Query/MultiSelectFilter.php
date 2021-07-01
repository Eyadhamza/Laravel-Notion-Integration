<?php


namespace Pi\Notion\Query;


class MultiSelectFilter implements Filterable
{

    public function setPropertyFilter($filter): array
    {


        return [
            'property'=> $filter->getName(),
            'multi_select'=> $this->setFilterConditions($filter)

        ];

    }
    public function setFilterConditions($filter): array|null
    {

        if ($filter->getContains()){
            return ['contains'=> $filter->getContains()];
        }
        if ($filter->getNotContain()){
            return ['does_not_contain'=> $filter->getNotContain()];
        }
        if ($filter->getIsNotEmpty()){
            return ['is_not_empty'=> $filter->getIsNotEmpty()];
        }
        if ($filter->getContains()){
            return ['is_empty'=> $filter->getIsEmpty()];
        }
      return null;
    }


}
