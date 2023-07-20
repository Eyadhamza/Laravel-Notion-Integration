<?php

namespace Pi\Notion\Core\Properties;

use Pi\Notion\Core\Content\NotionContent;
use Pi\Notion\Core\Content\NotionEmptyValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionCreatedTime extends BaseNotionProperty
{

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::CREATED_TIME;

        return $this;
    }

}
