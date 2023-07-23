<?php

namespace PISpace\Notion\Traits\Filters;

trait HasStringFilters
{
    use HasContainmentFilters, HasEqualityFilters;

    public function startsWith(string $query): self
    {
        return $this->applyFilter('starts_with', $query);
    }

    public function endsWith(string $query): self
    {
        return $this->applyFilter('ends_with', $query);
    }

}
