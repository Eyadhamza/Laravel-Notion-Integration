<?php

namespace Pi\Notion\Core\BlockContent;

use Pi\Notion\Enums\NotionBlockContentTypeEnum;
use Pi\Notion\Enums\NotionBlockTypeEnum;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionSimpleValue extends NotionContent
{
    public static function build(array $response): static
    {
        return new static($response['plain_text'], $response['type']);
    }

    public function setContentType(): NotionContent
    {
        $this->contentType = NotionBlockContentTypeEnum::SIMPLE_VALUE;
        return $this;
    }

    public function toArrayableValue(): array
    {
        return [
            $this->valueType->value => $this->value['value'] ?? new \stdClass(),
        ];
    }
}
