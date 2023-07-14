<?php

namespace Pi\Notion\Core\Query;

use Illuminate\Support\Collection;
use Pi\Notion\Traits\CreateFilterTypes;

class NotionFilter
{
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

    public static function make(string $type, string $property): NotionFilter
    {
        return new self($type, $property);
    }

    public static function group(array $filters, $connective): NotionFilter
    {
        $filter = new self('group', 'group');

        $filter->setFilterGroup($filters, $connective);

        return $filter;
    }

    public static function groupWithOr(array $filters): NotionFilter
    {
        return self::group($filters, 'or');
    }

    public static function groupWithAnd(array $filters): NotionFilter
    {
        return self::group($filters, 'and');
    }

    public function apply(string $filter, string $query): NotionFilter
    {
        $this->setQuery($query);
        $this->setFilterName($filter);
        return $this;
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

    public function compoundOrGroup(array $filters, $nestedConnective): self
    {
        $this->filterGroup->add([
            'or' => [
                $this->get(),
                $this->setNestedConnective($filters, $nestedConnective)
            ]
        ]);
        return $this;
    }

    public function compoundAndGroup(array $filters, $nestedConnective): self
    {
        $this->filterGroup->add([
            'and' => [
                $this->get(),
                $this->setNestedConnective($filters, $nestedConnective)
            ]
        ]);
        return $this;
    }


    private function setQuery(string $query): void
    {
        $this->query = $query;
    }

    private function setFilterName(string $filter): void
    {
        $this->filterName = $filter;
    }

    private function setFilterGroup(array $filters, $connective): Collection
    {
        $this->filterGroup->add([
            $connective =>
                collect($filters)->map(function (NotionFilter $filter) {
                    return $filter->get();
                })
        ]);
        return $this->filterGroup;
    }

    public function getFilterGroup(): Collection
    {
        return $this->filterGroup;
    }

    public function setConnective(string $connective): void
    {
        $this->connective = $connective;
    }

    public function getConnective(): string
    {
        return $this->connective;
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    private function setNestedConnective(array $filters, $nestedConnective): array
    {
        return [
            $nestedConnective => collect($filters)->map(function (NotionFilter $filter) {
                return $filter->get();
            })->toArray()
        ];
    }

    public function equals(string $query): self
    {
        return $this->apply('equals', $query);
    }

    public function contains(string $query): self
    {
        return $this->apply('contains', $query);
    }

}
