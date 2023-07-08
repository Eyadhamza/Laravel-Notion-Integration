<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionArrayValue;
use Pi\Notion\Core\NotionValue\NotionBlockContent;
use Pi\Notion\Core\NotionValue\NotionRichText;

class NotionDatabaseTitle extends BaseNotionProperty
{
    private NotionRichText $content;

    protected function buildValue(): NotionBlockContent
    {
        $this->content = NotionRichText::make($this->name)
            ->type('text')
            ->toResource();

        return NotionArrayValue::make($this->content->resource)
            ->type('title')
            ->isNested();
    }


    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::TITLE;

        return $this;
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['title'])){
            return $this;
        }

        $this->content = NotionRichText::make($response['title'][0]['plain_text'])
            ->type('text');

        return $this;
    }
}
