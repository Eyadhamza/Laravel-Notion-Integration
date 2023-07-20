<?php

namespace Pi\Notion\Core\Properties;

use Pi\Notion\Core\Content\NotionContent;
use Pi\Notion\Core\Content\NotionEmptyValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionLastEditedTime extends BaseNotionProperty
{

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::LAST_EDITED_TIME;

        return $this;
    }

}

