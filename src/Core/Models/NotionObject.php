<?php

namespace PISpace\Notion\Core\Models;


use PISpace\Notion\Core\Properties\NotionPropertyFactory;
use PISpace\Notion\Core\Query\NotionPaginator;
use PISpace\Notion\Enums\NotionPropertyTypeEnum;

class NotionObject
{
    protected ?string $parentId = null;
    protected ?string $objectType;
    protected ?string $id;
    protected ?string $url = null;
    protected ?string $icon;
    protected ?string $cover;
    protected NotionPaginator $paginator;

    public function __construct(string $id = null)
    {
        $this->id = $id;
    }

    public static function make(string $id = null): static
    {
        return new static($id);
    }

    public function fromResponse(array $response): self
    {
        $this->id = $response['id'] ?? null;
        $this->objectType = $response['object'];
        $this->setParent($response['parent'] ?? []);

        return $this;
    }

    protected function buildPropertiesFromResponse($response): static
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
