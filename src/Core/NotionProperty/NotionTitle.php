<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Traits\Filters\HasStringFilters;

class NotionTitle extends BaseNotionProperty
{
    use HasStringFilters;

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::TITLE;

        return $this;
    }

    public function mapToResource(): array
    {
        if (is_null($this->value)) return [];

        return [
            'content' => $this->value
        ];
    }

    public function setTitle(string $title): NotionTitle
    {
        $this->value = $title;
        return $this;
    }
}
