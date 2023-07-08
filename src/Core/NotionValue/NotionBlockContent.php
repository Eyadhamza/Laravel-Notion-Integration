<?php

namespace Pi\Notion\Core\NotionValue;

use Illuminate\Http\Resources\ConditionallyLoadsAttributes;

abstract class NotionBlockContent
{
    use ConditionallyLoadsAttributes;
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
        return new static($value);
    }

    abstract public static function build(array $response): static;

    public function resource(): array
    {
        return $this->filter($this->toResource());
    }

    abstract protected function toResource();

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
