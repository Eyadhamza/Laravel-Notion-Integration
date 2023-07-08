<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\NotionValue\NotionArrayValue;
use stdClass;

class NotionMultiSelect extends BaseNotionProperty
{
    private ?array $options = null;


    protected function buildValue()
    {
        return NotionArrayValue::make('options', $this->options);
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function setType(): BaseNotionProperty
    {
        // TODO: Implement setType() method.
    }
}
