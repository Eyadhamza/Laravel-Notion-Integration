<?php

namespace Pi\Notion\Core\NotionValue;

class NotionArrayValue extends NotionBlockContent
{
    public function __construct(string $type, array $value = null)
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
            $this->type => $this->value
        ];
    }
}
