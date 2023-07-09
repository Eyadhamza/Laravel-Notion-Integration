<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionArrayValue;
use Pi\Notion\Core\BlockContent\NotionBlockContent;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionMultiSelect extends BaseNotionProperty
{
    private ?array $options = null;


    protected function buildValue(): NotionBlockContent
    {
        return NotionArrayValue::make($this->options)->setValueType('multi_select');
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
