<?php

namespace Pi\Notion\Core\NotionValue;

use Illuminate\Http\Resources\ConditionallyLoadsAttributes;
use Illuminate\Http\Resources\MissingValue;

abstract class NotionBlockContent
{
    use ConditionallyLoadsAttributes;
    public mixed $resource;
    protected mixed $type;
    protected mixed $value;

    public function __construct(mixed $value = null)
    {
        $this->value = $value;
    }

    public static function make(mixed $value = null): self|NotionEmptyValue
    {

        if (! $value){
            return new NotionEmptyValue();
        }

        if (is_array($value) && self::areAllMissingValues($value)) {
            return new NotionEmptyValue();
        }

        return new static($value);
    }

    abstract public static function build(array $response): static;

    private static function areAllMissingValues(array $value): bool
    {
        foreach ($value as $item) {
            if (! $item instanceof MissingValue) {
                return false;
            }
        }

        return true;
    }

    public function resource(): mixed
    {
        $this->toResource();

        if (is_string($this->resource) || is_numeric($this->resource) || is_bool($this->resource)) {
            return $this->resource;
        }

        return $this->filter($this->resource);
    }

    abstract protected function toResource(): self;

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function type(mixed $type): static
    {
        $this->type = $type;
        return $this;
    }
}
