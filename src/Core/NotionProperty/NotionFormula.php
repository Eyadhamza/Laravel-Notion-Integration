<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionBlockContent;
use Pi\Notion\Core\BlockContent\NotionFormulaValue;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionFormula extends BaseNotionProperty
{
    private string $expression;

    private string $result;

    protected function buildValue(): NotionBlockContent
    {
        return NotionFormulaValue::make($this->expression)->setValueType('formula');
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

