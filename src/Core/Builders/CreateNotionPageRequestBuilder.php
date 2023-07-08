<?php

namespace Pi\Notion\Core\Builders;


use Illuminate\Support\Collection;
use Pi\Notion\Core\NotionProperty\BaseNotionProperty;

class CreateNotionPageRequestBuilder
{
    public string $databaseId;
    private Collection $properties;
    private Collection $blocks;

    public function __construct()
    {
        $this->properties = new Collection();
        $this->blocks = new Collection();
    }

    public static function make(): static
    {
        return new static();
    }

    public function setProperties(Collection $properties): static
    {
        $this->properties = $properties;

        return $this;
    }

    public function setBlocks(Collection $blocks): static
    {
        $this->blocks = $blocks;

        return $this;
    }

    public function build(): array
    {
        $properties = $this->properties->mapWithKeys(fn(BaseNotionProperty $property) => [
            $property->getName() => $property->resource()
        ])->all();

        if (! isset($this->databaseId)) {
            return [
                'properties' => $properties,
            ];
        }

        return [
            'parent' => [
                'database_id' => $this->databaseId,
            ],
            'properties' => $properties,
            'children' => $this->blocks,
        ];
    }

    public function setParent(string $databaseId): static
    {
        $this->databaseId = $databaseId;

        return $this;
    }

}
