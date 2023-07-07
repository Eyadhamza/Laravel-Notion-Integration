<?php

namespace Pi\Notion\Core\NotionProperty;

use stdClass;

class NotionPhoneNumber extends BaseNotionProperty
{

    public function setAttributes(): BaseNotionProperty
    {
        $this->attributes = [
            'phone_number' => $this->value ?? new stdClass(),
        ];

        return $this;
    }
}
