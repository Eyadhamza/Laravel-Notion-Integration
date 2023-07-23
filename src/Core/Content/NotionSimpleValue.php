<?php

namespace PISpace\Notion\Core\Content;

use PISpace\Notion\Enums\NotionBlockContentTypeEnum;
use PISpace\Notion\Enums\NotionBlockTypeEnum;
use PISpace\Notion\Enums\NotionPropertyTypeEnum;

class NotionSimpleValue extends NotionContent
{
    private ?string $key;

    public function __construct(NotionPropertyTypeEnum|NotionBlockTypeEnum $valueType, mixed $value = null, string $key = null)
    {
        parent::__construct($valueType, $value);
        $this->key = $key;
    }

    public static function make(NotionPropertyTypeEnum|NotionBlockTypeEnum $valueType, mixed $value = null, string $key = null): static|NotionEmptyValue
    {
        return new self($valueType, $value, $key);
    }

    public static function fromResponse(array $response): static
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
        if (isset($this->key)) {
            return [
                'type' => $this->blockType->value,
                $this->blockType->value => [
                    $this->key => $this->value ?? new \stdClass(),
                ],
            ];
        }

        return [
            $this->blockType->value => $this->value ?? new \stdClass(),
        ];
    }
}
