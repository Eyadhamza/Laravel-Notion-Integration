<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionEmptyValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionLastEditedTime extends BaseNotionProperty
{
    protected function buildValue(): NotionContent
    {
        return NotionEmptyValue::make()->setValueType('last_edited_time');
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['last_edited_time'])) {
            return $this;
        }
        $this->createdTime = $response['last_edited_time'];
        return $this;
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::LAST_EDITED_TIME;

        return $this;
    }
}

