<?php /** @noinspection ALL */


namespace Pi\Notion\Query;


use Illuminate\Support\Collection;

class SelectFilter implements Filterable
{

    public function set($filter): array
    {

       return array(
           'property'=> $filter->getName(),
                'select'=> is_null($filter->getOption()) ? $this->setFilterConditions($filter) : array('equals'=>$filter->getOption())

       );

    }
    public function setFilterConditions($conditions): array
    {
        return array(
                'equals'=>$conditions->getEquals() ,
                'does_not_equal'=>$conditions->getNotEqual(),
                'is_not_empty'=>$conditions->getIsNotEmpty(),
                'is_empty'=>$conditions->getIsEmpty()
        );
    }

}
