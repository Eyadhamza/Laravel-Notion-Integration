<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionArrayValue;
use Pi\Notion\Core\NotionValue\NotionBlockContent;
use Pi\Notion\Core\NotionValue\NotionEmptyValue;
use Pi\Notion\Core\NotionValue\NotionRichText;

class NotionTitle extends BaseNotionProperty
{
    private NotionRichText|NotionEmptyValue $content;

    public function __construct(string $name)
    {
        parent::__construct($name);

        $this->content = NotionRichText::make($this->name)
            ->setType('text');
    }

    public function setTitle(string $string): static
    {
        $this->content->text($string);

        return $this;
    }

    protected function buildValue(): NotionBlockContent
    {
        $this->content->toResource();

        return NotionArrayValue::make($this->content->resource)
            ->setType('title')
            ->isNested();
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

        $this->content = NotionRichText::make($response['title'][0]['plain_text'])
            ->setType('text');

        return $this;
    }
}
