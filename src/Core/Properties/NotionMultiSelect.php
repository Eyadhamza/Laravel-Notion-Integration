<?php

namespace Pi\Notion\Core\Properties;

use Pi\Notion\Core\Content\NotionArrayValue;
use Pi\Notion\Core\Content\NotionContent;
use Pi\Notion\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Traits\Filters\HasContainmentFilters;
use Pi\Notion\Traits\Filters\HasEqualityFilters;
use Pi\Notion\Traits\Filters\HasExistenceFilters;

class NotionMultiSelect extends BaseNotionProperty
{
    use HasExistenceFilters, HasContainmentFilters;

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
