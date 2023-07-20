<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Traits\Filters\HasStringFilters;

class NotionText extends BaseNotionProperty
{
    use HasStringFilters;

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::RICH_TEXT;

        return $this;
    }

    public function setText($text): self
    {
        $this->value = $text;
        return $this;
    }

}
