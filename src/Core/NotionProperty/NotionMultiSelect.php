<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionArrayValue;
use stdClass;

class NotionMultiSelect extends BaseNotionProperty
{
    private ?array $options = null;


    protected function buildValue()
    {
        return NotionArrayValue::make($this->options)->type('multi_select');
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::from('multi_select');

        return $this;
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['multi_select'])) {
            return $this;
        }
        $this->options = $response['multi_select'];
        return $this;
    }
}
