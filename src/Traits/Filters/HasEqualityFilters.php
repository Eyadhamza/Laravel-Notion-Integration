<?php

namespace Pi\Notion\Traits\Filters;

trait HasEqualityFilters
{
    public function equals(string $query): self
    {
        return $this->applyFilter('equals', $query);
    }

    public function doesNotEqual(string $query): self
    {
        return $this->applyFilter('does_not_equal', $query);
    }

}
