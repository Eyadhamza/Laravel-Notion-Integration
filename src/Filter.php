<?php

namespace Pi\Notion;

use Illuminate\Support\Collection;

class Filter
{
    private string $property;
    private string|array $query;
    private string $type;
    private string $filterName;

    public function __construct(string $type, string $property)
    {
        $this->property = $property;
        $this->type = $type;
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

    public function ofType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function ofProperty(string $property): self
    {
        $this->property = $property;
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

    private function setQuery(string $query): void
    {
        $this->query = $query;
    }

    private function setFilterName(string $filter):void
    {
        $this->filterName = $filter;
    }
}
