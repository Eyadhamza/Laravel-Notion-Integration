<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionEmptyValue;
use Pi\Notion\Core\NotionValue\NotionRichText;
use stdClass;

class NotionTitle extends BaseNotionProperty
{
    private ?string $title = null;


    protected function buildValue(): NotionRichText|NotionEmptyValue
    {
        return NotionRichText::make($this->title)->type('title');
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::TITLE;

        return $this;
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['title'])){
            return $this;
        }

        $this->title = $response['title'][0]['plain_text'];

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
