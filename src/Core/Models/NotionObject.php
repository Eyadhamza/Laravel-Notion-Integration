<?php

namespace Pi\Notion\Core\Models;


use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionProperty\NotionPropertyFactory;
use Pi\Notion\Core\Query\NotionPaginator;

abstract class NotionObject
{
    protected ?string $objectType;
    protected ?string $id;
    private string $parentType;
    protected ?string $parentId;
    protected ?bool $archived;
    protected ?string $createdTime;
    protected ?string $lastEditedTime;
    protected NotionUser $lastEditedBy;
    protected ?string $url;
    protected ?string $icon;
    protected ?string $cover;
    protected NotionPaginator $paginator;

    public static function fromResponse(array $response): static
    {
        $object = new static();
        $object->id = $response['id'] ?? null;
        $object->objectType = $response['object'];
        $object->parentType = $response['parent']['type'];
        $object->parentId = $response['parent'][$object->parentType];
        $object->archived = $response['archived'] ?? null;
        $object->createdTime = $response['created_time'];
        $object->lastEditedTime = $response['last_edited_time'];

        return $object;
    }

    protected function buildProperties($response): static
    {
        foreach ($response['properties'] as $propertyDate) {
            $property = NotionPropertyFactory::make(NotionPropertyTypeEnum::from($propertyDate['type']), $propertyDate);

            $this->properties->add($property);
        }

        return $this;
    }

}
