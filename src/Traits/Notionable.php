<?php

namespace Pi\Notion\Traits;

use LogicException;
use Pi\Notion\Core\NotionPage;

trait Notionable
{
    public array $notionMap = [];

    public abstract function mapToNotion(): array;

    public function saveToNotion(): NotionPage
    {
        $this->notionMap = $this->mapToNotion();
        if(!isset($this->notionDatabaseId)){
            throw new LogicException(get_class($this) . ' must have a Notion Database ID Property');
        }
        foreach ($this->getAttributes() as $key => $value) {
            if (array_key_exists($key, $this->notionMap)) {
                $this->notionMap[$key]->setValues($value);
            }
        }
        $page = new NotionPage();
        return $page->setDatabaseId($this->notionDatabaseId)
            ->setProperties($this->notionMap)
            ->create();
    }
    function getNotionDatabaseId(): string
    {
        return $this->notionDatabaseId;
    }
}
