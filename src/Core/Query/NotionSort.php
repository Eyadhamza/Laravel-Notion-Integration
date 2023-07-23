<?php

namespace PISpace\Notion\Core\Query;

use PISpace\Notion\Core\Properties\BaseNotionProperty;

class NotionSort
{
    private BaseNotionProperty $property;

    public function __construct(BaseNotionProperty $property)
    {
        $this->property = $property;
    }

    public static function make(BaseNotionProperty $property): NotionSort
    {
        return new self($property);
    }

    public function resource(): array
    {
        return [
            'property' => $this->property->getName(),
            'direction' => $this->property->getSortDirection()
        ];
    }

    public function getUsingTimestamp(): array
    {
        return [
            'timestamp' => $this->property->getName(),
            'direction' => $this->property->getSortDirection()
        ];
    }
}
