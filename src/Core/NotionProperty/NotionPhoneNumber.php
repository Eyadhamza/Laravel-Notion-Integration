<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\NotionValue\NotionSimpleValue;
use stdClass;

class NotionPhoneNumber extends BaseNotionProperty
{

    public function toArray(): array
    {
        return [
            'phone_number' => $this->value->toArray()
        ];
    }

    protected function buildValue(mixed $value)
    {
        $this->value = NotionSimpleValue::make('phone_number', $value);

        return $this->value;
    }
}
