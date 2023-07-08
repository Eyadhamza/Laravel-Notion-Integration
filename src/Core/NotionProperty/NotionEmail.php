<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\NotionValue\NotionSimpleValue;
use stdClass;

class NotionEmail extends BaseNotionProperty
{

    public function toArray(): array
    {
        return [
            'email' => $this->value->toArray()
        ];
    }

    protected function buildValue(mixed $value)
    {
        $this->value = NotionSimpleValue::make('email', $value);

        return $this->value;
    }
}
