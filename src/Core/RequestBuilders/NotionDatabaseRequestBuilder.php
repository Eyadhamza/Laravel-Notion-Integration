<?php

namespace PISpace\Notion\Core\RequestBuilders;

use Illuminate\Support\Collection;
use PISpace\Notion\Core\Properties\BaseNotionProperty;
use PISpace\Notion\Core\Properties\NotionDatabaseTitle;
use PISpace\Notion\Core\Properties\NotionTitle;

class NotionDatabaseRequestBuilder extends BaseNotionRequestBuilder
{
    private NotionTitle|NotionDatabaseTitle $title;
    private string $parentPageId;
    private Collection $properties;

    public function __construct(NotionTitle|NotionDatabaseTitle $title, string $parentPageId, Collection $properties)
    {
        $this->title = $title;
        $this->parentPageId = $parentPageId;
        $this->properties = $properties;
    }

    public static function make(NotionTitle|NotionDatabaseTitle $title, string $parentPageId, Collection $properties): static
    {
        return new static($title, $parentPageId, $properties);
    }

    public function toArray(): array
    {
        return array_merge($this->title->resource(), [
            'parent' => [
                'type' => 'page_id',
                'page_id' => $this->parentPageId
            ],
            'properties' => $this->properties->mapWithKeys(fn(BaseNotionProperty $property) => [
                $property->getName() => $property->resource()
            ])->all()
        ]);
    }
}
