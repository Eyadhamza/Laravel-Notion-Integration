<?php

namespace PISpace\Notion\Core\Properties;

use PISpace\Notion\Core\Content\NotionContent;
use PISpace\Notion\Core\Content\NotionSimpleValue;
use PISpace\Notion\Enums\NotionBlockTypeEnum;
use PISpace\Notion\Enums\NotionPropertyTypeEnum;

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
