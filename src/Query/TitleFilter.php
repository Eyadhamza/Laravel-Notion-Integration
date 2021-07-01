<?php /** @noinspection ALL */


namespace Pi\Notion\Query;


use Illuminate\Support\Collection;

class TitleFilter implements Filterable
{

    public function setPropertyFilter($filter): array
    {

       return array(
           'property'=> $filter->getName(),
                'title'=> $this->setFilterConditions($filter)

       );

    }
    public function setFilterConditions($filter): array
    {
        dd($filter->equals());
        if ($filter->getContains()){
            return ['equals'=> $filter->equals()];
        }
        if ($filter->getNotContain()){
            return ['does_not_equal'=> $filter->notEqual()];
        }
        if ($filter->getIsNotEmpty()){
            return ['is_not_empty'=> $filter->getIsNotEmpty()];
        }
        if ($filter->getContains()){
            return ['is_empty'=> $filter->getIsEmpty()];
        }
    }

}
