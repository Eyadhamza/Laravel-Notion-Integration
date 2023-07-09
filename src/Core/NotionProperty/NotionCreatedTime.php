<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionEmptyValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionCreatedTime extends BaseNotionProperty
{

    protected function buildValue(): NotionContent
    {
        return NotionEmptyValue::make()->setValueType($this->type);
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['created_time'])) {
            return $this;
        }
        $this->createdTime = $response['created_time'];
        return $this;
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::CREATED_TIME;

        return $this;
    }
}
