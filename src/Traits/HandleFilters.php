<?php

namespace Pi\Notion\Traits;

use Illuminate\Support\Collection;
use Pi\Notion\Core\Query\NotionFilter;

trait HandleFilters
{
    public function setFilters(array $filters): self
    {
        $this->filters = collect($filters);
        return $this;
    }

    private function getFilterResults(): array
    {
        if ($this->filters[0]->getFilterGroup()->isNotEmpty()) {
            return $this->filters[0]->getFilterGroup()[0];
        }
        return $this->resultsWithSingleFilter();
    }

    private function mapFilters(): Collection
    {
        return $this->filters->map(function (NotionFilter $filter) {
            return $filter->get();
        });
    }

    private function resultsWithSingleFilter(): array
    {
        return $this->mapFilters()[0];
    }
}
