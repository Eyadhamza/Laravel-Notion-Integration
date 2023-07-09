<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Models\NotionUser;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionEmptyValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionCreatedBy extends BaseNotionProperty
{
    public ?NotionUser $createdBy = null;


    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::CREATED_BY;

        return $this;
    }

    public function mapToResource(): array
    {
        return [
            'value' => $this->rawValue
        ];
    }

    public function setCreatedBy(?NotionUser $createdBy): NotionCreatedBy
    {
        $this->rawValue = $createdBy;
        return $this;
    }
}
