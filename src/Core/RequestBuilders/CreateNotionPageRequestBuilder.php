<?php

namespace Pi\Notion\Core\RequestBuilders;


use Illuminate\Support\Collection;
use Pi\Notion\Core\Models\NotionBlock;
use Pi\Notion\Core\NotionProperty\BaseNotionProperty;

class CreateNotionPageRequestBuilder
{
    public string $databaseId;
    private array $properties = [];
    private array $blocks = [];

    public static function make(): static
    {
        return new static();
    }

    public function setProperties(Collection $properties): self
    {
        $this->properties = $properties->mapWithKeys(fn(BaseNotionProperty $property) => [
            $property->getName() => $property->resource()
        ])->all();

        return $this;
    }

    public function setBlocks(Collection $blocks): self
    {
        $this->blocks = $blocks
            ->map(fn(NotionBlock $block) => $block->resource())
            ->all();

        return $this;
    }

    public function build(): array
    {
        if (! isset($this->databaseId)) {
            return [
                'properties' => $this->properties,
            ];
        }

        return [
            'parent' => [
                'database_id' => $this->databaseId,
            ],
            'properties' => $this->properties,
            'children' => $this->blocks,
        ];
    }

    public function setParent(string $databaseId): static
    {
        $this->databaseId = $databaseId;

        return $this;
    }

}
