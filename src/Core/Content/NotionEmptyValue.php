<?php

namespace PISpace\Notion\Core\Content;

use PISpace\Notion\Enums\NotionBlockContentTypeEnum;
use PISpace\Notion\Enums\NotionBlockTypeEnum;
use PISpace\Notion\Enums\NotionPropertyTypeEnum;

class NotionEmptyValue extends NotionContent
{
    public static function fromResponse(array $response): static
    {
        return new static("");
    }

    public function toArray(): array
    {
        return [
        ];
    }

    public function setContentType(): NotionContent
    {
        $this->contentType = NotionBlockContentTypeEnum::EMPTY_VALUE;
        return $this;
    }

    public function toArrayableValue(): array
    {
        return [
            $this->blockType->value => new \stdClass()
        ];
    }
}
