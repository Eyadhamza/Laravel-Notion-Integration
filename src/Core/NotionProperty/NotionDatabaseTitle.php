<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionRichText;

class NotionDatabaseTitle extends BaseNotionProperty
{
    protected function buildValue(): NotionRichText
    {
        return NotionRichText::make('text', $this->name);
    }


    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::TITLE;

        return $this;
    }
}
