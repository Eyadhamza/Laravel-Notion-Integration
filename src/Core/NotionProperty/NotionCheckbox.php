<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionSimpleValue;

class NotionCheckbox extends BaseNotionProperty
{
    private bool $isChecked = false;

    public function isChecked(bool $isChecked): NotionCheckbox
    {
        $this->isChecked = $isChecked;
        return $this;
    }

    protected function buildValue()
    {
        return NotionSimpleValue::make($this->isChecked)->type('checkbox');
    }

    public function setType(): self
    {
        $this->type = NotionPropertyTypeEnum::CHECKBOX;

        return $this;
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['checkbox'])){
            return $this;
        }

        $this->isChecked = $response['checkbox'];

        return $this;
    }
}
