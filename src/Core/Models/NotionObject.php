<?php

namespace Pi\Notion\Core\Models;


use Pi\Notion\Core\NotionProperty\NotionPropertyFactory;
use Pi\Notion\Core\Query\NotionPaginator;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionObject
{
    protected ?string $parentId;
    protected ?string $objectType;
    protected ?string $id;
    protected ?string $url = null;
    protected ?string $icon;
    protected ?string $cover;
    protected NotionPaginator $paginator;
    public static function make(): static
    {
        return new static();
    }

    public function fromResponse(array $response): self
    {
        $this->id = $response['id'] ?? null;
        $this->objectType = $response['object'];
        $this->setParent($response['parent'] ?? []);

        return $this;
    }

    protected function buildProperties($response): static
    {
        foreach ($response['properties'] as $propertyName => $propertyData) {
            $propertyData['name'] = $propertyName;

            $property = NotionPropertyFactory::make(NotionPropertyTypeEnum::from($propertyData['type']), $propertyName);
            $property->setValue($propertyData[$propertyData['type']] ?? null);
            $this->properties->put($propertyName, $property->fromResponse($propertyData));
        }

        return $this;
    }

    private function setParent(array $parent = []): self
    {
        if (empty($parent)) {
            return $this;
        }
        $parentType = $parent['type'];
        $this->parentId = $parent[$parentType];

        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }
}
