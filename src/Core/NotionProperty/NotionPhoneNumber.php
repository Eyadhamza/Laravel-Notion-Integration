<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\NotionValue\NotionSimpleValue;
use stdClass;

class NotionPhoneNumber extends BaseNotionProperty
{


    protected function buildValue()
    {
        return NotionSimpleValue::make('phone_number', $this->rawValue);
    }

    public function setType(): BaseNotionProperty
    {

    }
}
