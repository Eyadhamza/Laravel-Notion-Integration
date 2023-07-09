<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionArrayValue;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionEmptyValue;
use Pi\Notion\Core\BlockContent\NotionRichText;
use Pi\Notion\Enums\NotionBlockContentTypeEnum;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionDatabaseTitle extends BaseNotionProperty
{
    protected function buildValue(): NotionContent
    {
        return NotionRichText::make($this->name)
            ->setValueType($this->type)
            ->setContentType(NotionBlockContentTypeEnum::TITLE)
            ->buildResource();
    }


    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::TITLE;

        return $this;
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['title'])) {
            return $this;
        }

        $this->content = NotionRichText::make($response['title'][0]['plain_text'])
            ->setValueType($this->type);

        return $this;
    }
}
