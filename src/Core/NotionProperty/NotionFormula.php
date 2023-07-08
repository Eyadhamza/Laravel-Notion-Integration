<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionBlockContent;
use Pi\Notion\Core\NotionValue\NotionFormulaValue;

class NotionFormula extends BaseNotionProperty
{
    private string $expression;

    private string $result;

    protected function buildValue(): NotionBlockContent
    {
        return NotionFormulaValue::make($this->expression)->setType('formula');
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::FORMULA;

        return $this;
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        $this->expression = $response['formula']['type'];
        $this->result = $response['formula'][$this->expression];
        return $this;
    }

    public function setExpression(string $expression): NotionFormula
    {
        $this->expression = $expression;
        return $this;
    }

}

