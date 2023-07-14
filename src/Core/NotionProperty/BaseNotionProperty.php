<?php


namespace Pi\Notion\Core\NotionProperty;


use Illuminate\Http\Resources\Json\JsonResource;
use Pi\Notion\Core\BlockContent\NotionBlockContentFactory;
use Pi\Notion\Core\Models\NotionObject;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionEmptyValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

abstract class BaseNotionProperty extends NotionObject
{
    public JsonResource $resource;
    protected mixed $rawValue;
    protected NotionContent|NotionEmptyValue $blockContent;
    protected NotionPropertyTypeEnum $type;
    protected ?string $name;

    public function __construct(?string $name = null, ?string $rawValue = null)
    {
        $this->name = $name;
        $this->rawValue = $rawValue;
        $this->setType();
    }

    public static function make(?string $name = null, ?string $rawValue = null): static
    {
        return new static($name, $rawValue);
    }

    public function build(): static
    {
        $this->resource = new JsonResource($this->mapToResource());

        $this->buildContent();

        $this->blockContent->buildResource();

        return $this;
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

    protected function buildContent(): self
    {
        $this->blockContent = NotionBlockContentFactory::make($this);

        return $this;
    }

    public function fromResponse(array $response): static
    {
        $this->id = $response['id'];
        $this->type = NotionPropertyTypeEnum::tryFrom($response['type']);

        return $this->buildFromResponse($response);
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response[$this->type->value])) {
            return $this;
        }

        $this->rawValue = $response[$this->type->value];

        $this->build();

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

    abstract public function setType(): BaseNotionProperty;

    public function getRawValue(): mixed
    {
        return $this->rawValue;
    }

    public abstract function mapToResource(): array;

    public function setRawValue($value): self
    {
        $this->rawValue = $value;

        return $this;
    }

    public function getBlockContent(): NotionContent|NotionEmptyValue
    {
        return $this->blockContent;
    }

    public function hasRawValue(): bool
    {
        return !empty($this->rawValue);
    }

}
