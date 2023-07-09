<?php


namespace Pi\Notion\Core\NotionProperty;


use Illuminate\Http\Resources\Json\JsonResource;
use Pi\Notion\Core\Models\NotionObject;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionEmptyValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

abstract class BaseNotionProperty extends NotionObject
{
    protected NotionContent|NotionEmptyValue $blockContent;
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
    public function resource(): array
    {
        return $this->blockContent->resource->resolve();
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
    abstract protected function buildValue(): NotionContent;
    public function fromResponse(array $response): static
    {
        $this->id = $response['id'];
        $this->type = NotionPropertyTypeEnum::tryFrom($response['type']);

        return $this->buildFromResponse($response);
    }
    abstract protected function buildFromResponse(array $response): self;

    public function setBlockContent(): self
    {
        $this->blockContent = $this
            ->buildValue()
            ->buildResource();

        return $this;
    }

    public function getBlockContent(): NotionContent
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

    public function getName(): string
    {
        return $this->name;
    }

    abstract public function setType(): BaseNotionProperty;

}
