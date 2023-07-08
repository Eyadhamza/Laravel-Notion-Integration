<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionBlockContent;
use Pi\Notion\Core\NotionValue\NotionObjectValue;
use stdClass;

class NotionPhoneNumber extends BaseNotionProperty
{
    private ?string $phone = null;


    protected function buildValue(): NotionBlockContent
    {
        return NotionObjectValue::make($this->phone)->setType('phone_number');
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

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phone = $phoneNumber;
        return $this;
    }
}
