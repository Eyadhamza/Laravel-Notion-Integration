<?php

namespace Pi\Notion\Core\BlockContent;

use Pi\Notion\Enums\NotionBlockContentTypeEnum;

class NotionEmptyValue extends NotionContent
{
    public static function build(array $response): static
    {
        return new static("");
    }

    public function toArray(): array
    {
        return [
            $this->contentType->value => new \stdClass()
        ];
    }

    public function setContentType(): NotionContent
    {
        $this->contentType = NotionBlockContentTypeEnum::EMPTY_VALUE;
        return $this;
    }
}
