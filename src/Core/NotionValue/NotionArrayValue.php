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

    public function toResource(): array
    {
        if ($this->isNested) {
            return [
                $this->type => [
                    $this->value
                ]
            ];
        }
        if (isset($this->key)) {
            return [
                $this->type => [
                    $this->key => $this->value
                ]
            ];
        }

        return [
            $this->type => $this->value
        ];
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
