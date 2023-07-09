<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionArrayValue;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionObjectValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionPhoneNumber extends BaseNotionProperty
{
    private ?string $phone = null;


    protected function buildValue(): NotionContent
    {
        return NotionArrayValue::make($this->phone)
            ->setValueType($this->type);
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
