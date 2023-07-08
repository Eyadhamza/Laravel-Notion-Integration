<?php

namespace Pi\Notion\Core\NotionValue;

class NotionSimpleValue extends NotionBlockContent
{
    public function __construct(string $value = null)
    {
        parent::__construct($value);
    }

    public static function build(array $response): static
    {
        return new static($response['plain_text'], $response['type']);
    }

    protected function toResource(): ?string
    {
        return $this->value;
    }
}
