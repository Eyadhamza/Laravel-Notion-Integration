<?php


namespace Pi\Notion\Core\NotionProperty;


use Pi\Notion\Core\BlockContent\NotionPropertyContentFactory;
use Pi\Notion\Core\Models\NotionObject;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionEmptyValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

abstract class BaseNotionProperty extends NotionObject
{
    protected mixed $value;
    protected NotionContent|NotionEmptyValue $blockContent;
    protected NotionPropertyTypeEnum $type;
    protected ?string $name;
    private string $query;
    private string $filterName;
    private string $sortDirection;

    public function __construct(?string $name = null, ?string $value = null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->setType();
    }

    public static function make(?string $name = null, ?string $value = null): static
    {
        return new static($name, $value);
    }

    public function fromResponse(array $response): static
    {
        $this->id = $response['id'];
        $this->type = NotionPropertyTypeEnum::tryFrom($response['type']);

        if (empty($response[$this->type->value])) {
            return $this;
        }

        $this->setValue($response[$this->type->value]);

        $this->buildContent();

        return $this;
    }

    public abstract function setType(): BaseNotionProperty;

    public abstract function mapToResource(): array;

    public function resource(): array
    {
        return $this->blockContent->resource();
    }

    public function isPaginated(): bool
    {
        return match ($this->type) {
            NotionPropertyTypeEnum::ROLLUP,
            NotionPropertyTypeEnum::RELATION,
            NotionPropertyTypeEnum::RICH_TEXT => true,
            default => false
        };
    }

    public function buildContent(): self
    {
        $this->value = $this->mapToResource();

        $this->blockContent = NotionPropertyContentFactory::make($this);

        return $this;
    }


    public function getId(): ?string
    {
        return $this->id;
    }

    public function getType(): NotionPropertyTypeEnum
    {
        return $this->type;
    }

    public function getName(): ?string
    {
        return $this->name;
    }


    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getBlockContent(): NotionContent|NotionEmptyValue
    {
        return $this->blockContent;
    }

    public function hasValue(): bool
    {
        return !empty($this->value);
    }

    public function applyFilter(string $filterName, string $query): self
    {
        $this->query = $query;
        $this->filterName = $filterName;
        return $this;
    }

    public function getFilterName(): string
    {
        return $this->filterName;
    }

    public function getQuery(): string
    {
        return $this->query;
    }


    public function getSortDirection(): string
    {
        return $this->sortDirection;
    }

    public function descending(): self
    {
        $this->sortDirection = 'descending';
        return $this;
    }

    public function ascending(): self
    {
        $this->sortDirection = 'ascending';
        return $this;
    }
}
