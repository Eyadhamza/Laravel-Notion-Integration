<?php

namespace PISpace\Notion\Core\Properties;

use PISpace\Notion\Core\Content\NotionContent;
use PISpace\Notion\Core\Content\NotionEmptyValue;
use PISpace\Notion\Enums\NotionPropertyTypeEnum;
use PISpace\Notion\Traits\Filters\HasDateFilters;

class NotionCreatedTime extends BaseNotionProperty
{
    use HasDateFilters;

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::CREATED_TIME;

        return $this;
    }


}
