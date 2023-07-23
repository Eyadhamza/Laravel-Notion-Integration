<?php

namespace PISpace\Notion\Core\Properties;

use PISpace\Notion\Enums\NotionPropertyTypeEnum;
use PISpace\Notion\Traits\Filters\HasStringFilters;

class NotionTitle extends BaseNotionProperty
{
    use HasStringFilters;

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::TITLE;

        return $this;
    }

    public function setTitle(string $title): NotionTitle
    {
        $this->value = $title;
        return $this;
    }
}
