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

    public function filters(Collection|array $filters, $filterConnective = ''): self
    {

        $filters = is_array($filters) ? collect($filters) : $filters;
        $this->setFilterConnective($filterConnective);
        $this->setFilters($filters);

        return $this;
    }

    private function setFilters(Collection $filters): void
    {
        $this->filters = $filters;
    }


    private function getFilterResults(): array
    {
        if ($this->filters->count() > 1) {
            return $this->resultsWithConnective();
        }
        if ($this->filters[0]->getFilterGroup()->isNotEmpty()) {

            return $this->resultsWithFilterGroup();
        }
        return $this->resultsWithSingleFilter();
    }

    private function mapFilters(): Collection
    {
        return $this->filters->map(function (Filter $filter) {
            return $filter->get();
        });
    }

    private function resultsWithConnective(): array
    {
        return [$this->filterConnective => $this->mapFilters()];
    }

    private function resultsWithFilterGroup(): array
    {
        return  $this->filters[0]->getFilterGroup()[0]
        ;
    }
    private function resultsWithSingleFilter(): array
    {
        return  $this->mapFilters()[0];
    }
//    public function filterSelect(string $propertyName): Filter
//    {
//        return Filter::select($propertyName);
//    }
//    // public filter{anything}
    // { $database->filterSelect('Status', 'done')->get(); }
}
