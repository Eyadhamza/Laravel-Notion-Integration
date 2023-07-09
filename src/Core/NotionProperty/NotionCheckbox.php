<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionSimpleValue;
use Pi\Notion\Enums\NotionBlockTypeEnum;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionCheckbox extends BaseNotionProperty
{

    public function setType(): self
    {
        $this->type = NotionPropertyTypeEnum::CHECKBOX;

        return $this;
    }

    public function setChecked(bool $checked): self
    {
        $this->rawValue = $checked;

        return $this;
    }


    public function mapToResource(): array
    {
        return [
            'value' => $this->rawValue
        ];
    }
}
