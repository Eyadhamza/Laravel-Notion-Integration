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
        $notionMap = $this->mapToNotion();
        if(!isset($this->notionDatabaseId)){
            throw new LogicException(get_class($this) . ' must have a Notion Database ID Property');
        }
        foreach ($this->getAttributes() as $key => $value) {
            if (array_key_exists($key, $notionMap)) {
                $notionMap[$key]->setValues($value);
            }
        }
        $page = new NotionPage();
        $page->setDatabaseId($this->notionDatabaseId)
            ->setProperties($notionMap)
            ->create();
        return $page;
    }

}
