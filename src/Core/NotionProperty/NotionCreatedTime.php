<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionBlockContent;
use Pi\Notion\Core\NotionValue\NotionEmptyValue;

class NotionCreatedTime extends BaseNotionProperty
{

    protected function buildValue(): NotionBlockContent
    {
        return NotionEmptyValue::make()->type('created_time');
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
