<?php

namespace PISpace\Notion\Core\Properties;

use Illuminate\Http\Resources\MissingValue;
use PISpace\Notion\Enums\NotionPropertyTypeEnum;
use PISpace\Notion\Traits\Filters\HasEqualityFilters;

class NotionSelect extends BaseNotionProperty
{
    use HasEqualityFilters;
    private array $options;

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::SELECT;

        return $this;
    }
    public function setOptions(array $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function setSelected(string $option): self
    {
        $this->value = $option;

        return $this;
    }

    public function mapToResource(): array
    {
        return [
            'options' => $this->options ?? new MissingValue(),
            'name' => $this->value ?? new MissingValue()
        ];
    }
}
