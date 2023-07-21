<?php

namespace Pi\Notion\Core\Properties;

use Pi\Notion\Core\Content\NotionContent;
use Pi\Notion\Core\Content\NotionEmptyValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Traits\Filters\HasDateFilters;

class NotionCreatedTime extends BaseNotionProperty
{
    use HasDateFilters;

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::CREATED_TIME;

        return $this;
    }


}
