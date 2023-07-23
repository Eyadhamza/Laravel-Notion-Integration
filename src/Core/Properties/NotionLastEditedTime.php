<?php

namespace PISpace\Notion\Core\Properties;

use PISpace\Notion\Core\Content\NotionContent;
use PISpace\Notion\Core\Content\NotionEmptyValue;
use PISpace\Notion\Enums\NotionPropertyTypeEnum;

class NotionLastEditedTime extends BaseNotionProperty
{

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::LAST_EDITED_TIME;

        return $this;
    }

}

