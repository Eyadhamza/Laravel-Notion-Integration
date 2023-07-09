<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionBlockContent;
use Pi\Notion\Core\BlockContent\NotionSimpleValue;
use Pi\Notion\Enums\NotionBlockTypeEnum;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionCheckbox extends BaseNotionProperty
{
    private bool $isChecked = false;

    public function isChecked(bool $isChecked): NotionCheckbox
    {
        $this->isChecked = $isChecked;
        return $this;
    }

    protected function buildValue(): NotionBlockContent
    {
        return NotionSimpleValue::make($this->isChecked)
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

        $this->isChecked = $response['checkbox'];

        return $this;
    }

    public function setChecked(bool $checked): self
    {
        $this->isChecked = $checked;

        return $this;
    }


}
