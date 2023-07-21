<?php

namespace Pi\Notion\Core\Query;

use Illuminate\Support\Collection;
use Pi\Notion\Core\Properties\BaseNotionProperty;

class NotionFilter
{
    private BaseNotionProperty $property;

    private string|array $query;
    private string $filterName;
    private static Collection $filterGroup;

    public function __construct(BaseNotionProperty $property)
    {
        $this->property = $property;
        $this->filterName = $property->getFilterName();
        $this->query = $property->getQuery();
    }

    public static function make(BaseNotionProperty $property): NotionFilter
    {
        return new self($property);
    }

    public static function group(array $filters, string $connective): Collection
    {
        self::$filterGroup = new Collection();

        return self::$filterGroup
            ->put($connective, collect($filters)
                ->map(function (BaseNotionProperty|Collection $property) {
                    if ($property instanceof Collection) {
                        return $property->toArray();
                    }

                    return (new self($property))->resource();
                })
                ->all()
            );

    }

    public static function groupWithOr(array $filters): Collection
    {
        return self::group($filters, 'or');
    }

    public static function groupWithAnd(array $filters): Collection
    {
        return self::group($filters, 'and');
    }

    public function apply(string $filter, string $query): NotionFilter
    {
        return $this
            ->setQuery($query)
            ->setFilterName($filter);
    }


    public function resource(): array
    {
        if (!$this->property->getName()) {
            return [
                'timestamp' => $this->property->getType()->value,
                $this->property->getType()->value => [
                    $this->filterName => $this->query
                ]
            ];
        }
        return [
            'property' => $this->property->getName(),
            $this->property->getType()->value => [
                $this->filterName => $this->query
            ]
        ];
    }

    private function setQuery(string $query): self
    {
        $this->query = $query;

        return $this;
    }

    private function setFilterName(string $filter): self
    {
        $this->filterName = $filter;

        return $this;
    }

    public function getProperty(): BaseNotionProperty
    {
        return $this->property;
    }


}
