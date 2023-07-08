<?php

namespace Pi\Notion\Core\NotionValue;

class NotionArrayValue extends NotionBlockContent
{
    private string $key;
    private bool $isNested = false;

    public static function build(array $response): static
    {
        return new static($response['plain_text'], $response['type']);
    }

    public function toResource(): self
    {
        if ($this->isNested) {
            $this->resource = [
                $this->type => [
                    $this->value
                ]
            ];

            return $this;
        }
        if (isset($this->key)) {
            $this->resource = [
                $this->type => [
                    $this->key => $this->value
                ]
            ];

            return $this;
        }

        $this->resource = [
            $this->type => $this->value
        ];

        return $this;
    }

    public function setKey(string $key): NotionArrayValue
    {
        $this->key = $key;
        return $this;
    }

    public function isNested(): NotionArrayValue
    {
        $this->isNested = true;
        return $this;
    }
}
