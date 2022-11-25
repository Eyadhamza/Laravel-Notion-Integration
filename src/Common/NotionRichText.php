<?php

namespace Pi\Notion\Common;

use Illuminate\Support\Collection;

class NotionRichText extends BlockContent
{
    protected string $value;
    private Collection $annotations;
    private array $link;
    private array $values;
    private string $href;

    public function __construct(string $value)
    {
        parent::__construct($value, 'rich_text');
        $this->annotations = new Collection();
    }

    public static function make(string $value): NotionRichText
    {
        return new self($value);
    }

    public function setAnnotations(Collection $annotations): self
    {
        $this->annotations = $annotations;
        return $this;
    }

    public function bold(): self
    {
        $this->annotations->push('bold');
        return $this;
    }

    public function italic(): self
    {
        $this->annotations->push('italic');
        return $this;
    }

    public function strikethrough(): self
    {
        $this->annotations->push('strikethrough');
        return $this;
    }

    public function underline(): self
    {
        $this->annotations->push('underline');
        return $this;
    }

    public function code(): self
    {
        $this->annotations->push('code');
        return $this;
    }

    public function setPlainText(array $plainText): self
    {
        $this->plainText = $plainText;
        return $this;
    }

    public function setLink(string $link): self
    {
        $this->link = [
            'url' => $link
        ];
        return $this;
    }

    public function text(string $text, string $link): self
    {
        $this->values = [
            'text' => [
                'content' => $text,
                'link' => $link ?? null
            ]
        ];
        return $this;
    }

    public function mention(string $type): self
    {
        $this->values = [
            'mention' => [
                'type' => $type
            ]
        ];
        return $this;
    }

    public function equation(): self
    {
        $this->values = [
            'equation' => true
        ];
        return $this;
    }

    public function linkPreview($value): self
    {
        $this->values = [
            'url' => $value
        ];
        return $this;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function color(string $color)
    {
        $this->values = [
            'color' => $color
        ];
        return $this;
    }

    public function getValue(): array
    {
        return [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => $this->value,
                        'link' => $this->link ?? null
                    ],
                    'annotations' => [
                        'bold' => $this->annotations->contains('bold'),
                        'italic' => $this->annotations->contains('italic'),
                        'strikethrough' => $this->annotations->contains('strikethrough'),
                        'underline' => $this->annotations->contains('underline'),
                        'code' => $this->annotations->contains('code'),
                        'color' => $this->values['color'] ?? 'default'
                    ],
                    'plain_text' => $this->value ?? null,
                    'href' => $this->href ?? null
                ],

        ];

    }
}
