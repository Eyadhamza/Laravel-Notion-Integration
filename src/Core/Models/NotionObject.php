<?php

namespace Pi\Notion\Core\Models;


use Illuminate\Http\Resources\Json\JsonResource;
use Pi\Notion\Core\NotionProperty\NotionPropertyFactory;
use Pi\Notion\Core\Query\NotionPaginator;
use Pi\Notion\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Traits\HasResource;

class NotionObject
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

    public function fromResponse(array $response): self
    {
        $this->id = $response['id'] ?? null;
        $this->objectType = $response['object'];
        $this->setParent($response['parent'] ?? []);
        $this->archived = $response['archived'] ?? null;
        $this->createdTime = $response['created_time'] ?? null;
        $this->lastEditedTime = $response['last_edited_time'] ?? null;

        return $this;
    }

    protected function buildProperties($response): static
    {
        foreach ($response['properties'] as $propertyName => $propertyData) {
            $propertyData['name'] = $propertyName;

            $property = NotionPropertyFactory::make(NotionPropertyTypeEnum::from($propertyData['type']), $propertyName);

            $this->properties->put($property->getName(), $property->fromResponse($propertyData));
        }

        return $this;
    }

    private function setParent(array $parent = []): self
    {
        if (empty($parent)) {
            return $this;
        }
        $this->parentType = $parent['type'];
        $this->parentId = $parent[$this->parentType];

        return $this;
    }

}
