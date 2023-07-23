<?php

namespace PISpace\Notion\Core\Properties;

use PISpace\Notion\Enums\NotionPropertyTypeEnum;

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
