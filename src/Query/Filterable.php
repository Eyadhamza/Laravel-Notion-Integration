<?php


namespace Pi\Notion\Query;


interface Filterable
{
    public function set($filter);

    public function setFilterConditions($conditions);

}
