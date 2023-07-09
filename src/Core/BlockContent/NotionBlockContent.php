<?php

namespace Pi\Notion\Core\BlockContent;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use Pi\Notion\Enums\NotionBlockContentTypeEnum;
use Pi\Notion\Enums\NotionBlockTypeEnum;
use Pi\Notion\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Traits\HasResource;

abstract class NotionBlockContent
{
    use HasResource;

    public JsonResource $resource;
    protected NotionBlockContentTypeEnum $contentType;
    protected mixed $value;
    protected bool $isNested = false;
    public NotionBlockTypeEnum|NotionPropertyTypeEnum $valueType;
    public function __construct(mixed $value = null)
    {
        $this->value = $value;
        $this->setContentType();
    }

    public static function make(mixed $value = null): static|NotionEmptyValue
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

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getContentType(): NotionBlockContentTypeEnum
    {
        return $this->contentType;
    }
    public function setValueType(NotionBlockTypeEnum|NotionPropertyTypeEnum $valueType): self
    {
        $this->valueType = $valueType;
        return $this;
    }
    abstract public function setContentType(): self;


    public function isNested(): self
    {
        $this->isNested = true;
        return $this;
    }
}
