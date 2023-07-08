<?php


namespace Pi\Notion\Core\NotionProperty;


use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\Models\NotionObject;
use Pi\Notion\Core\NotionValue\NotionBlockContent;
use Pi\Notion\Core\NotionValue\NotionEmptyValue;

abstract class BaseNotionProperty extends NotionObject
{
    protected mixed $rawValue;
    protected ?NotionBlockContent $value;
    protected NotionPropertyTypeEnum $type;
    protected ?string $name;

    public function __construct(string $name, mixed $rawValue = null)
    {
        $this->name = $name;
        $this->rawValue = $rawValue;
        $this->setType()->setValue();
    }

    public static function make(string $name, mixed $rawValue = null): BaseNotionProperty
    {
        return new static($name, $rawValue);
    }


    public function toArray(): array
    {
        if (!$this->rawValue) {
            return $this->returnEmptyObject();
        }

        return [
            $this->type->value => [
                $this->value->resource()
            ]
        ];
    }

    abstract protected function buildValue();

    public static function build(array $response): static
    {
        $property = new static($response['name'] ?? '');
        $property->id = $response['id'];
        $property->type = NotionPropertyTypeEnum::tryFrom($response['type']);
        $property->buildValue($response[$response['type']]);
        return $property;
    }

    public function setValue(): self
    {
        $this->value = $this->buildValue();

        return $this;
    }

    public function getValue(): NotionBlockContent
    {
        return $this->value;
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

    private function returnEmptyObject(): array
    {
        $this->value = new NotionEmptyValue($this->type->value);

        return $this->value->resource();
    }


}
