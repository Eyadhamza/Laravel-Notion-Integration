<?php

namespace PISpace\Notion\Core\Properties;

use PISpace\Notion\Core\Models\NotionUser;
use PISpace\Notion\Core\Content\NotionContent;
use PISpace\Notion\Core\Content\NotionEmptyValue;
use PISpace\Notion\Enums\NotionPropertyTypeEnum;

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
