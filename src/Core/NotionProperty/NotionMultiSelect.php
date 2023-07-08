<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\NotionValue\NotionArrayValue;
use stdClass;

class NotionMultiSelect extends BaseNotionProperty
{
    private ?array $options = null;


    public function toArray(): array
    {
        // TODO: Implement toArray() method.
    }

    protected function buildValue()
    {
        return NotionArrayValue::make('options', $this->options);
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

}
