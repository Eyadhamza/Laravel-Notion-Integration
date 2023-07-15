<?php

namespace Pi\Notion\Core\BlockContent;

use Pi\Notion\Enums\NotionBlockContentTypeEnum;
use Pi\Notion\Enums\NotionBlockTypeEnum;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

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
                $this->valueType->value => [
                    $this->key => $this->value['value'] ?? new \stdClass(),
                ],
            ];
        }

        return [
            $this->valueType->value => $this->value['value'] ?? new \stdClass(),
        ];
    }
}
