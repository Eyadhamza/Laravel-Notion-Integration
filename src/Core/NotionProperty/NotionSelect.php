<?php

namespace Pi\Notion\Core\NotionProperty;

class NotionSelect extends BaseNotionProperty
{
    private string|array $options;
    private mixed $values;

    public function setOptions(array|string $options): self
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return array|string
     */
    public function getOptions(): array|string
    {
        return $this->options;
    }

    public function setAttributes(): BaseNotionProperty
    {
        $this->attributes = [
            'select' => $this->options ?? new \stdClass()
        ];

        return $this;
    }
}
