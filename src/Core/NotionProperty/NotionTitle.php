<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionTitle extends BaseNotionProperty
{

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::TITLE;

        return $this;
    }

    public function mapToResource(): array
    {
        if (is_null($this->rawValue)) return [];

        return [
            'content' => $this->rawValue
        ];
    }

    public function setTitle(string $title): NotionTitle
    {
        $this->rawValue = $title;
        return $this;
    }
}
