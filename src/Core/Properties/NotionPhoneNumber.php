<?php

namespace Pi\Notion\Core\Properties;

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
        $this->value = $phoneNumber;
        return $this;
    }

}
