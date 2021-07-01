<?php /** @noinspection ALL */


namespace Pi\Notion\Query;


use Illuminate\Support\Collection;

class SelectFilter implements Filterable
{

    public function setPropertyFilter($filter): array
    {

       return array(
           'property'=> $filter->getName(),
           'select'=>  $this->setFilterConditions($filter)

       );

    }
    public function setFilterConditions($filter): array|null
    {


        if ($filter->getEquals()){
            return ['equals'=> $filter->getEquals()];
        }
        if ($filter->getNotEqual()){
            return ['does_not_equal'=> $filter->getNotEqual()];
        }
        if ($filter->getIsNotEmpty()){
            return ['is_not_empty'=> $filter->getIsNotEmpty()];
        }
        if ($filter->getIsEmpty()){
            return ['is_empty'=> $filter->getIsEmpty()];
        }
        return ['equals'=> $filter->getEquals()];

    }

}
