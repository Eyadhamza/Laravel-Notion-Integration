<?php

namespace Pi\Notion\Core\NotionValue;

use Illuminate\Http\Resources\MissingValue;

class NotionObjectValue extends NotionBlockContent
{

    public static function build(array $response): static
    {
        return new static($response['plain_text'], $response['type']);
    }

    public function toResource(): self
    {
         $this->resource = [
            'type' => $this->type,
            $this->type => $this->value ?? new MissingValue()
        ];

        return $this;
    }
}
