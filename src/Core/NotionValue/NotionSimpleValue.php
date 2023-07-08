<?php

namespace Pi\Notion\Core\NotionValue;

class NotionSimpleValue extends NotionBlockContent
{

    public static function build(array $response): static
    {
        return new static($response['plain_text'], $response['type']);
    }

    protected function toResource(): self
    {
        $this->resource = [
            $this->type => $this->value,
        ];

        return $this;
    }
}
