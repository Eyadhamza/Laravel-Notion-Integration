<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionText extends BaseNotionProperty
{

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

    public function mapToResource(): array
    {
        return [
            'content' => $this->value
        ];
    }
}
