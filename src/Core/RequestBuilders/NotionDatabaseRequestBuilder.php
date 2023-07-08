<?php

namespace Pi\Notion\Core\RequestBuilders;

use Illuminate\Support\Collection;
use Pi\Notion\Core\NotionProperty\BaseNotionProperty;
use Pi\Notion\Core\NotionProperty\NotionDatabaseTitle;

class NotionDatabaseRequestBuilder extends BaseNotionRequestBuilder
{
    private NotionDatabaseTitle $title;
    private string $parentPageId;
    private Collection $properties;

    public function __construct(NotionDatabaseTitle $title, string $parentPageId, Collection $properties)
    {
        $this->title = $title;
        $this->parentPageId = $parentPageId;
        $this->properties = $properties;
    }

    public static function make(NotionDatabaseTitle $title, string $parentPageId, Collection $properties): static
    {
        return new static($title, $parentPageId, $properties);
    }

    public function toArray(): array
    {
//        dd(array_merge($this->title->toArray(), [
//            'parent' => [
//                'type' => 'page_id',
//                'page_id' => $this->parentPageId
//            ],
//            'properties' => $this->properties->mapWithKeys(fn(BaseNotionProperty $property) => [
//                $property->getName() => $property->toArray()
//            ])->all()
//        ]));
        return array_merge($this->title->toArray(), [
            'parent' => [
                'type' => 'page_id',
                'page_id' => $this->parentPageId
            ],
            'properties' => $this->properties->mapWithKeys(fn(BaseNotionProperty $property) => [
                $property->getName() => $property->toArray()
            ])->all()
        ]);
    }
}
