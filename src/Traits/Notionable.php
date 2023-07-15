<?php

namespace Pi\Notion\Traits;

use LogicException;
use Pi\Notion\Core\BlockContent\NotionPropertyContentFactory;
use Pi\Notion\Core\Models\NotionPage;
use Pi\Notion\Core\NotionProperty\BaseNotionProperty;

trait Notionable
{
    public array $notionMap = [];

    public abstract function mapToNotion(): array;

    public function saveToNotion(string $pageId = null): NotionPage
    {
        $this->notionMap = $this->mapToNotion();

        $this->validateHasNotionDatabaseId();

        $this->notionMap = $this->buildNotionProperties();

        if ($pageId){
            return NotionPage::make()
                ->setProperties($this->notionMap)
                ->update($pageId);
        }

        return NotionPage::make()
            ->setDatabaseId($this->notionDatabaseId)
            ->setProperties($this->notionMap)
            ->create();
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

    public function buildNotionProperties(): array
    {
        return collect($this->getAttributes())->map(function ($value, $key) {
            if (array_key_exists($key, $this->notionMap)) {
                /** @var BaseNotionProperty $property */
                $property = $this->notionMap[$key];

                if ($property->hasValue() && ! isset($property->resource)){
                    return $property->build();
                }

                return $property->setValue($value)->build();
            }
        })->filter()->toArray();
    }
}
