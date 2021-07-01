<?php


namespace Pi\Notion\Query;


interface Filterable
{
    public function setPropertyFilter($filter);

    public function setFilterConditions($filter);

}
