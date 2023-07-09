<?php

namespace Pi\Notion\Core\BlockContent;

use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Collection;
use Pi\Notion\Enums\NotionBlockContentTypeEnum;

class NotionRichText extends NotionContent
{
    private Collection $annotations;
    private ?array $link;
    private array $attributeValues;
    private ?string $href;

    public function __construct(mixed $value = null)
    {
        parent::__construct($value);
        $this->annotations = new Collection();
        $this->link = null;
        $this->attributeValues = [];
        $this->href = null;
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

    public function toArray(): array
    {
        return [
            $this->contentType->value => [
                array_merge($this->getAnnotations(), [
                    'type' => 'text',
                    'text' => [
                        'content' => $this->value,
                        'link' => $this->link ?? new MissingValue(),
                    ],
                    'plain_text' => $this->value ?? new MissingValue(),
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
