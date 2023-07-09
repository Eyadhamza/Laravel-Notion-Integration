<?php

namespace Pi\Notion\Traits;

use LogicException;
use Pi\Notion\Core\Models\NotionPage;
use Pi\Notion\Core\NotionProperty\BaseNotionProperty;

trait Notionable
{
    public array $notionMap = [];

    public abstract function mapToNotion(): array;

    public function saveToNotion(): NotionPage
    {
        $this->notionMap = $this->mapToNotion();

        $this->validateHasNotionDatabaseId();

        collect($this->getAttributes())->map(function ($value, $key) {
            if (array_key_exists($key, $this->notionMap)) {

                /** @var BaseNotionProperty $property */
                $property = $this->notionMap[$key];
                $property->setValue($value);
            }
        });

        $page = new NotionPage();
        return $page
            ->setDatabaseId($this->notionDatabaseId)
            ->setProperties($this->notionMap)
            ->create();
    }

    public function mapFromNotion(NotionPage $page): array
    {
        $attributes = [];

        foreach ($this->mapToNotion() as $key => $value) {
            /** @var BaseNotionProperty $property */
            $property = $page->ofPropertyName($value->getName());
            $attributes[$key] = $property->getValue();
        }
        return $attributes;
    }

    public function getNotionDatabaseId(): string
    {
        return $this->notionDatabaseId;
    }

    abstract public function getAttributes();

    public function validateHasNotionDatabaseId(): self
    {
        if (!isset($this->notionDatabaseId)) {
            throw new LogicException('Notionable class must have a notionDatabaseId property');
        }

        return $this;
    }
}
