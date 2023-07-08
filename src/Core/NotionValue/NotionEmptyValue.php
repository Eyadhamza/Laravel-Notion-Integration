<?php

namespace Pi\Notion\Core\NotionValue;

class NotionEmptyValue extends NotionBlockContent
{
    public static function build(array $response): static
    {
        return new static("");
    }

    public function toResource(): self
    {
        $this->resource = [
            $this->type => new \stdClass()
        ];

        return $this;
    }
}
