<?php

namespace Pi\Notion\Core\Properties;

use Illuminate\Http\Resources\MissingValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Traits\Filters\HasContainmentFilters;
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
        return array_merge($this->value ?? [], [
            'options' => $this->options ?? new MissingValue(),
        ]);
    }

    public function setSelectedNames(array $names): self
    {
        $this->value = collect($names)->map(fn($name) => ['name' => $name])->all();

        return $this;
    }
}
