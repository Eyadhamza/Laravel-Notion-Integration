<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionRichText;
use stdClass;

class NotionTitle extends BaseNotionProperty
{
    protected function buildValue(): NotionRichText
    {
        return NotionRichText::make('text', $this->rawValue);
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::TITLE;

        return $this;
    }
}
