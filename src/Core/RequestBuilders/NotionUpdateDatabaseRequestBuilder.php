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

    public function __construct(NotionDatabaseTitle $title, NotionDatabaseDescription $description, Collection $properties)
    {
        $this->title = $title;
        $this->properties = $properties;
    }

    public static function make(NotionDatabaseTitle $title, NotionDatabaseDescription $description, Collection $properties): static
    {
        return new static($title, $description, $properties);
    }

    public function toArray(): array
    {
        return array_merge($this->title->getAttributes(), [
            'parent' => [
                'type' => 'page_id',
                'page_id' => $this->parentPageId
            ],
            'properties' => $this->properties->mapWithKeys(fn(BaseNotionProperty $property) => [
                $property->getName() => $property->getAttributes()
            ])->all()
        ]);
    }
}
