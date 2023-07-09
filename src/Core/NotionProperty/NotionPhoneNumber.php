<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionPhoneNumber extends BaseNotionProperty
{

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::PHONE_NUMBER;

        return $this;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->rawValue = $phoneNumber;
        return $this;
    }

    public function mapToResource(): array
    {
        return [
            'value' => $this->rawValue
        ];
    }
}
