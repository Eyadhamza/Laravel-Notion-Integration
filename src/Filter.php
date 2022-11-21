<?php

namespace Pi\Notion;

use Closure;
use Illuminate\Support\Collection;
use Pi\Notion\Traits\NotionFilters;

class Filter
{
    use NotionFilters;

    private string $property;
    private string|array $query;
    private string $type;
    private string $filterName;
    private string $connective;
    private Collection $filterGroup;

    public function __construct(string $type, string $property)
    {
        $this->property = $property;
        $this->type = $type;
        $this->filterGroup = new Collection();
    }

    public static function make(string $type, string $property): Filter
    {
        return new self($type, $property);
    }


    public function apply(string $filter, string $query): Filter
    {
        $this->setQuery($query);
        $this->setFilterName($filter);
        return $this;
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function get(): array
    {
        return [
            'property' => $this->property,
            $this->type => [
                $this->filterName => $this->query
            ]
        ];
    }

    private function setQuery(string $query): void
    {
        $this->query = $query;
    }

    private function setFilterName(string $filter): void
    {
        $this->filterName = $filter;
    }

    public function groupWithOrConnective(array $filters, $nestedConnective): self
    {
        $this->filterGroup->add([
            'or' => [
                $this->get(),
                [$nestedConnective => collect($filters)->map->get()]
            ]
        ]);

        return $this;
    }

    public function groupWithAndConnective(array $filters, $nestedConnective): self
    {
        $this->filterGroup->add([
            'and' => [
                $this->get(),
                [$nestedConnective => collect($filters)->map->get()]
            ]
        ]);

        return $this;
    }

    public function getFilterGroup(): Collection
    {
        return $this->filterGroup;
    }
}
