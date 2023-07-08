<?php

namespace Pi\Notion\Core\RequestBuilders;

use Illuminate\Support\Collection;
use Pi\Notion\Core\NotionProperty\BaseNotionProperty;
use Pi\Notion\Core\NotionProperty\NotionDatabaseDescription;
use Pi\Notion\Core\NotionProperty\NotionTitle;

class NotionUpdateDatabaseRequestBuilder extends BaseNotionRequestBuilder
{
    private NotionTitle $title;
    private Collection $properties;
    private NotionDatabaseDescription $description;

    public function __construct(NotionTitle $title, NotionDatabaseDescription $description, Collection $properties)
    {
        $this->title = $title;
        $this->description = $description;
        $this->properties = $properties;
    }

    public static function make(NotionTitle $title, NotionDatabaseDescription $description, Collection $properties): static
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
