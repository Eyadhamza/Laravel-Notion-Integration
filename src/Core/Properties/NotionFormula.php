<?php

namespace Pi\Notion\Core\Properties;

use Illuminate\Http\Resources\MissingValue;
use Pi\Notion\Core\Content\NotionContent;
use Pi\Notion\Core\Content\NotionFormulaValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionFormula extends BaseNotionProperty
{
    public ?string $expression = null;

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::FORMULA;

        return $this;
    }

    public function setExpression(string $expression): NotionFormula
    {
        $this->expression = $expression;
        return $this;
    }

    public function mapToResource(): array
    {
        return [
            'expression' => $this->expression
        ];
    }
}

