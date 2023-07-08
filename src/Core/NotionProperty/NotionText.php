<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionBlockContent;
use Pi\Notion\Core\NotionValue\NotionEmptyValue;
use Pi\Notion\Core\NotionValue\NotionRichText;
use stdClass;

class NotionText extends BaseNotionProperty
{
    private NotionRichText $text;


    protected function buildValue(): NotionBlockContent
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

        return $this;
    }

    public function setText(NotionRichText $text): NotionText
    {
        $this->text = $text;
        return $this;
    }
}
