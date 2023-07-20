<?php

namespace Pi\Notion\Core\Properties;

use Pi\Notion\Core\Models\NotionUser;
use Pi\Notion\Core\Content\NotionContent;
use Pi\Notion\Core\Content\NotionEmptyValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionCreatedBy extends BaseNotionProperty
{
    public ?NotionUser $createdBy = null;


    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::CREATED_BY;

        return $this;
    }

    public function setCreatedBy(?NotionUser $createdBy): NotionCreatedBy
    {
        $this->value = $createdBy;
        return $this;
    }
}
