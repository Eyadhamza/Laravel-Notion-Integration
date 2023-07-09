<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionTitle extends BaseNotionProperty
{
    public ?string $title = null;

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::TITLE;

        return $this;
    }

    public function mapToResource(): array
    {
        if (is_null($this->title)) return [];

        return [
            'content' => $this->title
        ];
    }

    public function setTitle(string $title): NotionTitle
    {
        $this->title = $title;
        return $this;
    }
}
