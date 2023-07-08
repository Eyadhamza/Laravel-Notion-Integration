<?php

namespace Pi\Notion\Core\NotionValue;

use Illuminate\Http\Resources\ConditionallyLoadsAttributes;

abstract class NotionBlockContent
{
    use ConditionallyLoadsAttributes;
    protected mixed $type;
    protected mixed $value;

    public function __construct(string $type, mixed $value = null)
    {
        $this->value = $value;
        $this->type = $type;
    }

    public static function make(string $type, mixed $value = null): self
    {
        return new static($type, $value);
    }

    abstract public static function build(array $response): static;

    public function resource(): array
    {
        return $this->filter($this->toArray());
    }

    abstract protected function toArray(): array;

    public function getValue(): string
    {
        return $this->value;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
