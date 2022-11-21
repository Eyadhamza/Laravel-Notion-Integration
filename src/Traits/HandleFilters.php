<?php

namespace Pi\Notion\Traits;

use BadMethodCallException;
use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Pi\Notion\Filter;

trait HandleFilters
{

    public function filter(Filter $filter): self
    {
        $this->filters = new Collection();

        $this->filters->push($filter);

        return $this;
    }

    public function filters(Collection|array $filters): self
    {

        $filters = is_array($filters) ? collect($filters) : $filters;
        $this->setFilters($filters);

        return $this;
    }

    private function setFilters(Collection $filters): void
    {
        $this->filters = $filters;
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
        return $this->filters->map(function (Filter $filter) {
            return $filter->get();
        });
    }

    private function resultsWithSingleFilter(): array
    {
        return $this->mapFilters()[0];
    }
}
