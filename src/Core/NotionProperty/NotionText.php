<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionEmptyValue;
use Pi\Notion\Core\BlockContent\NotionRichText;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionText extends BaseNotionProperty
{
    protected function buildValue(): NotionContent
    {
        if (is_string($this->value)) {
            return NotionRichText::make($this->value)
                ->setValueType($this->type)
                ->buildResource();
        }
        return $this->value ?? new NotionEmptyValue();
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::RICH_TEXT;

        return $this;
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['text'])) {
            return $this;
        }
        // TODO: Implement buildFromResponse() method.

        return $this;
    }

    public function setText(NotionRichText $text): NotionText
    {
        $this->value = $text;
        return $this;
    }
}
