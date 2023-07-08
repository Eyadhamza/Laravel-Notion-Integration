<?php

namespace Pi\Notion\Core\RequestBuilders;

use Illuminate\Support\Collection;
use Pi\Notion\Core\NotionProperty\BaseNotionProperty;
use Pi\Notion\Core\NotionProperty\NotionDatabaseDescription;
use Pi\Notion\Core\NotionProperty\NotionDatabaseTitle;

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
            $this->title->toArray(),
            $this->description->toArray(), [
            'properties' => $this->properties->mapWithKeys(fn(BaseNotionProperty $property) => [
                $property->getName() => $property->toArray()
            ])->all()
        ]);
    }
}
