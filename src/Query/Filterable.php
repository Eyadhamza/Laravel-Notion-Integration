<?php


namespace Pi\Notion\Query;


interface Filterable
{
    public function setPropertyFilter();
    public function setFilterConditions();

}
