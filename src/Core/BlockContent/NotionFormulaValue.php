<?php

namespace Pi\Notion\Core\BlockContent;

use Illuminate\Http\Resources\MissingValue;
use Pi\Notion\Enums\NotionBlockContentTypeEnum;
use Pi\Notion\Enums\NotionFormulaTypeEnum;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionFormulaValue extends NotionBlockContent
{
    private ?NotionFormulaTypeEnum $expressionType = null;

    public static function build(array $response): static
    {
        return new static($response['plain_text']);
    }

    public function toArray(): array
    {
        return array_merge($this->getExpressionTypeIfSet(), [
            'type' => NotionPropertyTypeEnum::FORMULA->value,
            'formula' => [
                'expression' => $this->value ?? new MissingValue(),
            ]
        ]);

    }

    public function expression(string $expression): NotionFormulaValue
    {
        $this->expression = $expression;
        return $this;
    }

    public function ofType(string $type): NotionFormulaValue
    {
        $this->expressionType = NotionFormulaTypeEnum::from($type);
        return $this;
    }

    public function ofValue(mixed $value): NotionFormulaValue
    {
        $this->expressionValue = $value;
        return $this;
    }

    private function getExpressionTypeIfSet(): array
    {
        if (!$this->expressionType) {
            return [];
        }

        return [
            'type' => $this->expressionType->value,
            $this->expressionType->value => $this->expressionValue ?? new MissingValue()
        ];
    }

    public function setContentType(): NotionBlockContent
    {
        $this->contentType = NotionBlockContentTypeEnum::FORMULA;
        return $this;
    }
}
