<?php

namespace Pi\Notion\Core\BlockContent;

use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Collection;
use Pi\Notion\Enums\NotionBlockContentTypeEnum;
use Pi\Notion\Enums\NotionBlockTypeEnum;
use Pi\Notion\Traits\HasResource;

class NotionTextValue extends NotionContent
{
    private ?string $href;

    public function __construct(mixed $value = null)
    {
        parent::__construct($value);
        $this->href = null;
    }

    public static function build(array $response): static
    {
        $richText = new static($response[0]['plain_text'], $response[0]['type']);
        $richText->link = $response[0]['text']['link'];
        $richText->href = $response[0]['href'];
        return $richText;
    }


    public function toArray(): array
    {
        return [
            $this->contentType->value => [
                'content' => $this->value,
            ]
        ];

    }


    public function setContentType(): self
    {
        $this->contentType = NotionBlockContentTypeEnum::TEXT;

        return $this;
    }

    public function text(string $text, string $link = null): self
    {
        $this->value = $text;

        if ($link) {
            $this->setLink($link);
        }

        return $this;
    }

}
