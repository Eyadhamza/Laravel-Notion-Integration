<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionArrayValue;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Enums\NotionBlockTypeEnum;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionSelect extends BaseNotionProperty
{
    private array $options;

    private string $selected;

    protected function buildValue(): NotionContent
    {
        if (isset($this->selected)) {
            return NotionArrayValue::make(['name' => $this->selected])
                ->setValueType($this->type);

        }

        return NotionArrayValue::make($this->options)
            ->setValueType($this->type)
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
