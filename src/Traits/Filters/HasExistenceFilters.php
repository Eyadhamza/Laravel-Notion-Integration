<?php

namespace Pi\Notion\Traits\Filters;

trait HasExistenceFilters
{
    public function isEmpty(string $query): self
    {
        return $this->applyFilter('is_empty', $query);
    }

    public function isNotEmpty(string $query): self
    {
        return $this->applyFilter('is_not_empty', $query);
    }

}
