<?php


namespace Pi\Notion\Core\NotionProperty;


use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\Models\NotionObject;
use Pi\Notion\Core\NotionValue\NotionBlockContent;
use Pi\Notion\Core\NotionValue\NotionEmptyValue;

abstract class BaseNotionProperty extends NotionObject
{
    protected mixed $rawValue;
    protected NotionBlockContent|NotionEmptyValue $blockContent;
    protected NotionPropertyTypeEnum $type;
    protected ?string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->setType();
    }

    public static function make(string $name): static
    {
        return new static($name);
    }

    public function build(): static
    {
        return $this->setBlockContent();
    }
    public function toArray(): array
    {
        if ($this->blockContent->getValue() instanceof NotionEmptyValue) {
            return $this->blockContent->resource();
        }

        return $this->blockContent->resource();
    }

    abstract protected function buildValue(): NotionBlockContent;
    public static function fromResponse(array $response): static
    {
        $property = new static($response['name'] ?? '');
        $property->id = $response['id'];
        $property->type = NotionPropertyTypeEnum::tryFrom($response['type']);

        return $property->buildFromResponse($response);
    }
    abstract protected function buildFromResponse(array $response): self;

    public function setBlockContent(): self
    {
        $this->blockContent = $this->buildValue();

        return $this;
    }

    public function getBlockContent(): NotionBlockContent
    {
        return $this->blockContent;
    }

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

    abstract public function setType(): BaseNotionProperty;


}
