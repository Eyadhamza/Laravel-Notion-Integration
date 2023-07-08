<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\NotionValue\NotionSimpleValue;
use stdClass;

class NotionUrl extends BaseNotionProperty
{

    public function toArray(): array
    {
        return [
            'url' => $this->value->toArray()
        ];
    }

    protected function buildValue()
    {
        return NotionSimpleValue::make('url', $this->rawValue);
    }
}
