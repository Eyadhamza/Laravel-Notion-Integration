<?php

namespace Pi\Notion\Core\BlockContent;

use Pi\Notion\Enums\NotionBlockContentTypeEnum;

class NotionSimpleValue extends NotionContent
{

    public static function build(array $response): static
    {
        return new static($response['plain_text'], $response['type']);
    }

    public function toArray(): array
    {
        return [
            $this->valueType->value => $this->value['value'] ?? new \stdClass(),
        ];
    }

    public function setContentType(): NotionContent
    {
        $this->contentType = NotionBlockContentTypeEnum::SIMPLE_VALUE;
        return $this;
    }
}
