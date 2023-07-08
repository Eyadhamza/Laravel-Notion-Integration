<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionArrayValue;
use Pi\Notion\Core\NotionValue\NotionBlockContent;
use Pi\Notion\Core\NotionValue\NotionEmptyValue;
use Pi\Notion\Core\NotionValue\NotionRichText;

class NotionDatabaseDescription extends BaseNotionProperty
{

    private NotionBlockContent|NotionEmptyValue $content;

    protected function buildValue(): NotionArrayValue|NotionEmptyValue
    {
        $this->content = NotionRichText::make($this->name)
            ->type('text')
            ->toResource();

        return NotionArrayValue::make($this->content->resource)
            ->type('description')
            ->isNested();
    }

    protected function buildFromResponse(array $response): self
    {
        if (isset($response['description'])) {
            $this->blockContent = $response['description'][0][0];
        }

        return $this;
    }

    public function setType(): self
    {
        $this->type = NotionPropertyTypeEnum::TITLE;

        return $this;
    }
}
