<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionArrayValue;

class NotionSelect extends BaseNotionProperty
{
    private ?array $options = null;

    protected function buildValue()
    {
        return NotionArrayValue::make('options', $this->options);
    }
    public function setOptions(array|string $options): self
    {
        $this->options = $options;
        return $this;
    }

    public function getOptions(): array|string
    {
        return $this->options;
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::SELECT;

        return $this;
    }
}
