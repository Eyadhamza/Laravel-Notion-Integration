<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionSimpleValue;

class NotionDate extends BaseNotionProperty
{

    protected function buildValue()
    {
        return NotionSimpleValue::make('start', $this->rawValue);
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::DATE;

        return $this;
    }
}
