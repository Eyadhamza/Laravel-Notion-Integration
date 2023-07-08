<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionArrayValue;
use Pi\Notion\Core\NotionValue\NotionBlockContent;

class NotionSelect extends BaseNotionProperty
{
    private array $options;

    private string $selected;

    protected function buildValue(): NotionBlockContent
    {
        if (isset($this->selected)) {
            return NotionArrayValue::make(['name' => $this->selected])
                ->type('select');
        }

        return NotionArrayValue::make($this->options)
            ->type('select')
            ->setKey('options');
    }

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

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['select']) || empty($response['select']['options'])) {
            return $this;
        }
        $this->options = $response['select']['options'];

        return $this;
    }

    public function setSelected(string $option): self
    {
        $this->selected = $option;

        return $this;
    }
}
