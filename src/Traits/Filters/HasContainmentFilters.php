<?php

namespace PISpace\Notion\Traits\Filters;

trait HasContainmentFilters
{
    public function contains(string $query): self
    {
        return $this->applyFilter('contains', $query);
    }

    public function doesNotContain(string $query): self
    {
        return $this->applyFilter('does_not_contain', $query);
    }

}
