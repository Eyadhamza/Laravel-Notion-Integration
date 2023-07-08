<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionRichText;
use stdClass;

class NotionText extends BaseNotionProperty
{
    private NotionRichText $text;

    protected function buildValue()
    {
        return $this->text;
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
}
