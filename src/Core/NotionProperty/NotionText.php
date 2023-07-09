<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionEmptyValue;
use Pi\Notion\Core\BlockContent\NotionRichText;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionText extends BaseNotionProperty
{
    private NotionRichText $text;


    protected function buildValue(): NotionContent
    {
        return $this->text ?? new NotionEmptyValue();
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
        $this->text = $text;
        return $this;
    }
}
