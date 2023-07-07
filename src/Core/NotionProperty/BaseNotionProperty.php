<?php


namespace Pi\Notion\Core\NotionProperty;


use Illuminate\Support\Collection;
use Pi\Notion\Common\NotionRichText;
use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionDatabase;
use Pi\Notion\Core\NotionObject;
use Pi\Notion\Core\NotionPage;
use Pi\Notion\PropertyType;
use Pi\Notion\Traits\CreatePropertyTypes;
use stdClass;

abstract class BaseNotionProperty extends NotionObject
{
    protected mixed $value;

    protected NotionPropertyTypeEnum $type;
    protected ?string $name;
    protected array $attributes = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function make(string $name): BaseNotionProperty
    {
        return new static($name);
    }

    public static function build(array $response): static
    {
        $property = new static($response['name']);
        $property->id = $response['id'];
        $property->type = NotionPropertyTypeEnum::tryFrom($response['type']);
        $property->attributes = $response[$response['type']];

        return $property;
    }
    abstract public function setAttributes(): self;
    public function setValues(array|string $values): self
    {
        match ($this->type) {
            'title' => $this->setTitleValue($values),
            'rich_text' => $this->setRichTextValue($values),
            default => $this->values = $values,
        };
        return $this;
    }

    public function setMultipleValues(array $values): self
    {
        $this->values = collect($values)->map(function ($optionName) {
            return ['name' => $optionName];
        })->toArray();
        return $this;
    }

    public function getValues(): array|string
    {
        if (!isset($this->values)) {
            return [];
        }
        if (is_array($this->values)) {
            return $this->isNested() ? array($this->values) : array($this->values)[0];
        }
        return $this->values;
    }

    public function getValue(): mixed
    {
        return $this->value ?? null;
    }
    private function isNested(): bool
    {
        return in_array($this->type, [
            PropertyType::TITLE,
            PropertyType::RICH_TEXT
        ]);
    }

    public function isPaginated(): bool
    {
        return in_array($this->type, [
            PropertyType::TITLE,
            PropertyType::RICH_TEXT,
            PropertyType::RELATION,
            PropertyType::PEOPLE,
        ]);
    }

//    public function getOptions(): array|stdClass
//    {
//        if (!isset($this->options)) {
//            return new stdClass();
//        }
//        if (is_array($this->options)) {
//            return [
//                'options' => $this->options
//            ];
//        }
//        return array($this->options);
//    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getType(): NotionPropertyTypeEnum
    {
        return $this->type;
    }

    public function ofName(string $name): bool
    {
        return $this->name == $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    private function setTitleValue(array|string $values): static
    {
        $this->values = ['text' => ['content' => $values]];
        return $this;
    }

    private function setRichTextValue(array|string $values): static
    {
        $this->values = NotionRichText::make($values)
            ->toArray();
        return $this;
    }

    public function getAttributes(): array
    {
        return $this->attributes ?? [];
    }

    public function setValue(mixed $value): BaseNotionProperty
    {
        $this->value = $value;
        return $this;
    }
}
