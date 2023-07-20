<?php

namespace Pi\Notion\Core\Properties;

use Pi\Notion\Core\Content\NotionContent;
use Pi\Notion\Core\Content\NotionSimpleValue;
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
        $this->value = $checked;

        return $this;
    }

}
