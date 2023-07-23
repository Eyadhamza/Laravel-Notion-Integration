<?php

namespace PISpace\Notion\Core\Properties;

use Illuminate\Http\Resources\MissingValue;
use PISpace\Notion\Enums\NotionPropertyTypeEnum;
use PISpace\Notion\Traits\Filters\HasContainmentFilters;
use PISpace\Notion\Traits\Filters\HasExistenceFilters;

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
