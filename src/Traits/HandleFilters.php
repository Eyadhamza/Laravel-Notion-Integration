<?php

namespace Pi\Notion\Traits;

use Illuminate\Support\Collection;
use Pi\Notion\Filter;

trait HandleFilters
{

    public function filter(Filter $filter): self
    {
        $this->filters = new Collection();

        $this->filters->push($filter);

        return $this;
    }

    public function applyFilters(Collection|array $filters, $filterType): self
    {
        $filters = is_array($filters) ? collect($filters) : $filters;
        $this->setFilterType($filterType);
        $this->setFilters($filters);

        return $this;
    }

    private function setFilters(Collection $filters): void
    {
        $this->filters = $filters;
    }

    private function setFilterType($filterType): void
    {
        $this->filterType = $filterType;
    }

    private function getFilterResults(): array
    {
        if ($this->filters->count() > 1) {
            return [
                'filter' => [$this->filterType => $this->mapFilters()]
            ];
        }
        return [
            'filter' => $this->mapFilters()[0]
        ];
    }

    private function mapFilters(): Collection
    {
        return $this->filters->map(function (Filter $filter) {
            return $filter->get();
        });
    }
}
