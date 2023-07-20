<?php

namespace Pi\Notion\Core\Content;

use Pi\Notion\Enums\NotionBlockContentTypeEnum;

class NotionArrayValue extends NotionContent
{
    private string $key;


    public static function fromResponse(array $response): static
    {
        return new static($response['plain_text'], $response['type']);
    }

    public function toArrayableValue(): array
    {
        if ($this->isNested) {
            return [
                $this->blockType->value => [
                    $this->value->resolve()
                ]
            ];
        }
        if (isset($this->key)) {
            return [
                $this->blockType->value => [
                    $this->key => $this->value
                ]
            ];
        }

        return [
            $this->blockType->value => $this->value
        ];
    }

    public function setKey(string $key): NotionArrayValue
    {
        $this->key = $key;
        return $this;
    }

    public function setContentType(): NotionContent
    {
        $this->contentType = NotionBlockContentTypeEnum::ARRAY_VALUE;

        return $this;
    }
}
