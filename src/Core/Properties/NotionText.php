<?php

namespace PISpace\Notion\Core\Properties;

use PISpace\Notion\Enums\NotionPropertyTypeEnum;
use PISpace\Notion\Traits\Filters\HasStringFilters;

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
