<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionArrayValue;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionMultiSelect extends BaseNotionProperty
{
    public ?array $options = null;

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::from('multi_select');

        return $this;
    }

    public function mapToResource(): array
    {
        return [
            'options' => $this->options,
        ];
    }
}
