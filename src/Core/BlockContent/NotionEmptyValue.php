<?php

namespace Pi\Notion\Core\BlockContent;

use Pi\Notion\Enums\NotionBlockContentTypeEnum;

class NotionEmptyValue extends NotionBlockContent
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

    public function setContentType(): NotionBlockContent
    {
        $this->contentType = NotionBlockContentTypeEnum::EMPTY_VALUE;
        return $this;
    }
}
