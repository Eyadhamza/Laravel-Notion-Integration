<?php

namespace Pi\Notion\Core;

class NotionSort
{
    private string $property;
    private string $direction;

    public function __construct(string $property, string $direction)
    {
        $this->property = $property;
        $this->direction = $direction;
    }

    public static function make(string $property, string $direction): NotionSort
    {
        return new self($property, $direction);
    }

    public static function property(string $property): NotionSort
    {
        return self::make($property, 'ascending');
    }

    public function get(): array
    {
        return [
            'property' => $this->property,
            'direction' => $this->direction
        ];
    }

    public function descending(): self
    {
        $this->direction = 'descending';
        return $this;
    }

    public function ascending(): self
    {
        $this->direction = 'ascending';
        return $this;
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }

    public function getUsingTimestamp(): array
    {
        return [
            'timestamp' => $this->property,
            'direction' => $this->direction
        ];
    }
}
