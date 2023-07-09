<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionArrayValue;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionRichText;
use Pi\Notion\Enums\NotionBlockContentTypeEnum;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionDatabaseDescription extends BaseNotionProperty
{

    protected function buildValue(): NotionContent
    {
        return NotionRichText::make($this->name)
            ->setValueType($this->type)
            ->setContentType(NotionBlockContentTypeEnum::DESCRIPTION)
            ->buildResource();
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
