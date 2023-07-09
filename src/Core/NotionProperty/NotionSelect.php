<?php

namespace Pi\Notion\Core\NotionProperty;

use Illuminate\Http\Resources\MissingValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionSelect extends BaseNotionProperty
{
    public string $selected;
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
        $this->selected = $option;

        return $this;
    }

    public function mapToResource(): array
    {
        return [
            'options' => $this->options ?? new MissingValue(),
            'name' => $this->selected ?? new MissingValue()
        ];
    }
}
