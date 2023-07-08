<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionSimpleValue;

class NotionUrl extends BaseNotionProperty
{
    private ?string $link = null;

    protected function buildValue()
    {
        return NotionSimpleValue::make($this->link);
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::URL;

        return $this;
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['url'])) {
            return $this;
        }

        $this->link = $response['url'];

        return $this;
    }
}
