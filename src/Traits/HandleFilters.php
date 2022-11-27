<?php

namespace Pi\Notion\Traits;

use Illuminate\Support\Collection;
use Pi\Notion\Core\NotionFilter;

trait HandleFilters
{

    public function filter(NotionFilter $filter): self
    {
        $this->filters = new Collection();

        $this->filters->push($filter);

        return $this;
    }

    public function filters(array $filters): self
    {
        $this->setFilters(collect($filters));

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
        return $this->filters->map(function (NotionFilter $filter) {
            return $filter->get();
        });
    }
    private function resultsWithSingleFilter(): array
    {
        return $this->mapFilters()[0];
    }
}
