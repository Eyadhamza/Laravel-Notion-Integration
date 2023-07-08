<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionObjectValue;
use stdClass;

class NotionPhoneNumber extends BaseNotionProperty
{
    private string $phone;

    protected function buildValue()
    {
        return NotionObjectValue::make($this->phone)->type('phone_number');
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::PHONE_NUMBER;

        return $this;
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['phone_number'])) {
            return $this;
        }
        $this->phone = $response['phone_number'];
        return $this;
    }
}
