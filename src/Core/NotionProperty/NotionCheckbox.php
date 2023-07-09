<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionSimpleValue;
use Pi\Notion\Enums\NotionBlockTypeEnum;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionCheckbox extends BaseNotionProperty
{

    protected function buildValue(): NotionContent
    {
        return NotionSimpleValue::make($this->value)
            ->setValueType($this->type);
    }

    public function setType(): self
    {
        $this->type = NotionPropertyTypeEnum::CHECKBOX;

        return $this;
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['checkbox'])) {
            return $this;
        }

        $this->value = $response['checkbox'];

        return $this;
    }

    public function isChecked(bool $isChecked): NotionCheckbox
    {
        $this->value = $isChecked;
        return $this;
    }

    public function setChecked(bool $checked): self
    {
        $this->isChecked = $checked;

        return $this;
    }


}
