<?php

namespace Pi\Notion\Core\NotionValue;

class NotionObjectValue extends NotionBlockContent
{

    public static function build(array $response): static
    {
        return new static($response['plain_text'], $response['type']);
    }

    public function toResource(): array
    {
        return [
            'type' => $this->type,
            'plain_text' => $this->value
        ];
    }
}
