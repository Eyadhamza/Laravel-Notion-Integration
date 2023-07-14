<?php

namespace Pi\Notion\Core\BlockContent;

use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Collection;
use Pi\Notion\Enums\NotionBlockContentTypeEnum;
use Pi\Notion\Enums\NotionBlockTypeEnum;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionRichText extends NotionContent
{
    private Collection $annotations;
    private ?array $link;
    private array $attributeValues;
    private ?string $href;

    public function __construct(NotionBlockTypeEnum|NotionPropertyTypeEnum $valueType, mixed $value = null)
    {
        $this->annotations = new Collection();
        $this->link = null;
        $this->attributeValues = [];
        $this->href = null;
        parent::__construct($valueType, $value);

    }

    public static function build(array $response): static
    {
        $richText = new static($response[0]['plain_text'], $response[0]['type']);
        $richText->link = $response[0]['text']['link'];
        $richText->buildAnnotations($response[0]['annotations']);
        $richText->href = $response[0]['href'];
        return $richText;
    }

    private function buildAnnotations(array $annotations): void
    {
        foreach ($annotations as $key => $value) {
            if ($value) {
                $this->annotations->add([$key => $value]);
            }
        }
    }

    public function bold(): self
    {
        $this->annotations->put('bold', true);
        return $this;
    }

    public function italic(): self
    {
        $this->annotations->put('italic', true);
        return $this;
    }

    public function strikethrough(): self
    {
        $this->annotations->put('strikethrough', true);
        return $this;
    }

    public function underline(): self
    {
        $this->annotations->put('underline', true);
        return $this;
    }

    public function code(): self
    {
        $this->annotations->put('code', true);
        return $this;
    }

    public function setLink(string $link): self
    {
        $this->link = [
            'url' => $link
        ];
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

    public function mention(string $type): self
    {
        $this->attributeValues = [
            'mention' => [
                'type' => $type
            ]
        ];
        return $this;
    }

    public function equation(): self
    {
        $this->attributeValues = [
            'equation' => true
        ];
        return $this;
    }

    public function linkPreview($value): self
    {
        $this->attributeValues = [
            'url' => $value
        ];
        return $this;
    }

    public function getAttributeValues(): array
    {
        return $this->attributeValues;
    }

    public function color(string $color): self
    {
        $this->attributeValues = [
            'color' => $color
        ];
        return $this;
    }

    public function toArrayableValue(): array
    {
        $key = $this->valueType->value ?? $this->contentType->value;
        $value = is_array($this->value) ? $this->value['content'] : $this->value;

        return [
            $key => [
                array_merge($this->getAnnotations(), [
                    'type' => 'text',
                    'text' => [
                        'content' => $value,
                        'link' => $this->link ?? new MissingValue(),
                    ],
                    'plain_text' => $value,
                    'href' => $this->href ?? new MissingValue()
                ])
            ]
        ];

    }

    public function getAnnotations(): array|MissingValue
    {
        return $this->annotations->isNotEmpty() ? ['annotations' => $this->annotations->all()] : [];
    }

    public function setContentType(NotionBlockContentTypeEnum $contentType = null): self
    {
        $this->contentType = $contentType ?? NotionBlockContentTypeEnum::RICH_TEXT;

        return $this;
    }

}
