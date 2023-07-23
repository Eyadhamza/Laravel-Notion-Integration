<?php

namespace PISpace\Notion\Core\Properties;

use Illuminate\Http\Resources\MissingValue;
use PISpace\Notion\Core\Content\NotionContent;
use PISpace\Notion\Core\Content\NotionFormulaValue;
use PISpace\Notion\Enums\NotionPropertyTypeEnum;

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

