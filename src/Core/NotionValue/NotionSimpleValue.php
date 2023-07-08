<?php

namespace Pi\Notion\Core\NotionValue;

class NotionSimpleValue extends NotionBlockContent
{
    public function __construct(string $type, string $value = null)
    {
        parent::__construct($type, $value);
    }

    public static function build(array $response): static
    {
        return new static($response['plain_text'], $response['type']);
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'plain_text' => $this->value
        ];
    }
}
