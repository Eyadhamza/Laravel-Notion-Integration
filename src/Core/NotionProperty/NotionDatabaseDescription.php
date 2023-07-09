<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\NotionValue\NotionArrayValue;
use Pi\Notion\Core\NotionValue\NotionBlockContent;
use Pi\Notion\Core\NotionValue\NotionEmptyValue;
use Pi\Notion\Core\NotionValue\NotionRichText;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionDatabaseDescription extends BaseNotionProperty
{

    private NotionBlockContent|NotionEmptyValue $content;

    protected function buildValue(): NotionBlockContent
    {
        $this->content = NotionRichText::make($this->name)
            ->setType('text')
            ->toResource();

        return NotionArrayValue::make($this->content->resource)
            ->setType('description')
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
