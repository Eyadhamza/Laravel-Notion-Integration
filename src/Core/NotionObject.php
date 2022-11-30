<?php

namespace Pi\Notion\Core;


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

    public static function build($response): static
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
        foreach ($response['properties'] as $name => $property) {
            $this->properties->add(NotionProperty::build($property, $name));
        }

        return $this;
    }

}