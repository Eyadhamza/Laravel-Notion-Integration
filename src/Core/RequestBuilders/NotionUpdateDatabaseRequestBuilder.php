<?php

namespace PISpace\Notion\Core\RequestBuilders;

use Illuminate\Support\Collection;
use PISpace\Notion\Core\Properties\BaseNotionProperty;
use PISpace\Notion\Core\Properties\NotionDatabaseDescription;
use PISpace\Notion\Core\Properties\NotionDatabaseTitle;
use PISpace\Notion\Core\Properties\NotionTitle;

class NotionUpdateDatabaseRequestBuilder extends BaseNotionRequestBuilder
{
    private NotionDatabaseTitle $title;
    private Collection $properties;
    private NotionDatabaseDescription $description;

    public function __construct(NotionDatabaseTitle $title, NotionDatabaseDescription $description, Collection $properties)
    {
        $this->title = $title;
        $this->description = $description;
        $this->properties = $properties;
    }

    public static function make(NotionDatabaseTitle $title, NotionDatabaseDescription $description, Collection $properties): static
    {
        return new static($title, $description, $properties);
    }

    public function toArray(): array
    {
        return array_merge(
            $this->title->resource(),
            $this->description->resource(), [
            'properties' => $this->properties->mapWithKeys(fn(BaseNotionProperty $property) => [
                $property->getName() => $property->resource()
            ])->all()
        ]);
    }
}
