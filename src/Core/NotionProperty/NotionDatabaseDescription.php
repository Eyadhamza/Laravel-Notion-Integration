<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionArrayValue;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionEmptyValue;
use Pi\Notion\Core\BlockContent\NotionRichText;
use Pi\Notion\Core\BlockContent\NotionTextValue;
use Pi\Notion\Enums\NotionBlockContentTypeEnum;
use Pi\Notion\Enums\NotionBlockTypeEnum;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionDatabaseDescription extends BaseNotionProperty
{

    protected function buildValue(): NotionContent
    {
        $content = NotionTextValue::make($this->name)
            ->buildResource();

        return NotionArrayValue::make($content->resource)
            ->setValueType( NotionPropertyTypeEnum::DESCRIPTION)
            ->isNested();
    }

    protected function buildFromResponse(array $response): self
    {
        if (isset($response['description'])) {
            $this->blockContent = $response['description'][0][0];
        }

        return $this;
    }

    public function setType(): self
    {
        $this->type = NotionPropertyTypeEnum::TITLE;

        return $this;
    }
}
