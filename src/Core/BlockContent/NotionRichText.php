<?php

namespace Pi\Notion\Core\BlockContent;

use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Collection;
use Pi\Notion\Enums\NotionBlockContentTypeEnum;
use Pi\Notion\Enums\NotionBlockTypeEnum;
use Pi\Notion\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Traits\HasAnnotations;
use Pi\Notion\Traits\HasChildren;

class NotionRichText extends NotionContent
{
    use HasChildren, HasAnnotations;

    private ?array $link = null;
    private array $mainAttributes = [];
    protected array $specialAttributes = [];
    private ?string $href = null;
    private ?string $mainColor;
    private ?string $icon;
    private ?string $codeLanguage;
    private ?bool $isToggleable;
    private ?NotionRichText $caption;

    public function __construct(NotionBlockTypeEnum|NotionPropertyTypeEnum $valueType, mixed $value = null)
    {
        $this->annotations = new Collection();
        $this->children = new Collection();
        parent::__construct($valueType, $value);
    }


    public static function fromResponse(array $response): static
    {
        $richText = new static(NotionPropertyTypeEnum::RICH_TEXT, $response[0]['plain_text']);
        $richText->link = $response[0]['text']['link'];
        $richText->buildAnnotations($response[0]['annotations']);
        $richText->href = $response[0]['href'];
        return $richText;
    }


    public static function text(string $text, string $link = null): self
    {
        $richText = new self(NotionPropertyTypeEnum::RICH_TEXT, $text);

        $richText->value = [
            'content' => $text,
            'link' => $link ?? new MissingValue(),
        ];

        return $richText;
    }

    public static function getOrCreate(NotionRichText|string $richText): NotionRichText
    {
        if ($richText instanceof NotionRichText) {
            return $richText;
        }

        return self::text($richText);
    }

    public static function collection(array $items, NotionBlockTypeEnum $valueType): array
    {
        return collect($items)
            ->map(fn(NotionRichText|string $item) => NotionRichText::getOrCreate($item)->setBlockType($valueType))
            ->all();
    }

    public function getMainAttributes(): array
    {
        return $this->mainAttributes;
    }


    public function toArrayableValue(): array
    {
        return match (get_class($this->blockType)) {
            NotionPropertyTypeEnum::class => $this->nestedStructure(),
            NotionBlockTypeEnum::class => $this->simpleStructure(),
        };

    }

    private function nestedStructure(): array
    {
        return [
            $this->blockType->value => [
                $this->getBody()
            ]
        ];
    }

    private function simpleStructure(): array
    {
        return [
            $this->blockType->value => [
                $this->contentType->value => [
                    $this->getBody()
                ],
                'is_toggleable' => $this->isToggleable ?? new MissingValue(),
                'children' => $this->getChildren(),
                'caption' => $this->caption ?? new MissingValue(),
                'color' => $this->mainColor ?? new MissingValue(),
                'icon' => $this->icon ?? new MissingValue(),
                'language' => $this->codeLanguage ?? new MissingValue(),
            ],
        ];
    }

    public function blockTypeResource(): array
    {
        return [
            $this->blockType->value => $this->getBody(),
            'is_toggleable' => $this->isToggleable ?? new MissingValue(),
            'children' => $this->getChildren(),
        ];
    }

    private function getBody(): array|MissingValue
    {
        $value = is_array($this->value) ? $this->value['content'] : $this->value;

        return array_merge(
            $this->getAnnotations(),
            $this->getSubAttributes(),
            [
                'type' => 'text',
                'text' => [
                    'content' => $value,
                    'link' => $this->link ?? new MissingValue(),
                ],
                'plain_text' => $value,
                'href' => $this->href ?? new MissingValue(),
            ]);
    }

    public function setMainColor(?string $mainColor): NotionRichText
    {
        $this->mainColor = $mainColor;
        return $this;
    }

    public function setIcon(?string $icon): NotionRichText
    {
        $this->icon = $icon;
        return $this;
    }

    public function setCodeLanguage(?string $codeLanguage): NotionRichText
    {
        $this->codeLanguage = $codeLanguage;
        return $this;
    }

    public function setCaption(?NotionRichText $caption): NotionRichText
    {
        $this->caption = $caption;
        return $this;
    }

    private function getSubAttributes(): array
    {
        return $this->specialAttributes;
    }

    public function isToggleable(): self
    {
        $this->isToggleable = true;
        return $this;
    }


    protected function setContentType(): self
    {
        $this->contentType = NotionBlockContentTypeEnum::RICH_TEXT;

        return $this;
    }

}
