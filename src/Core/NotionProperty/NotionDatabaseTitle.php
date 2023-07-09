<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionArrayValue;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionEmptyValue;
use Pi\Notion\Core\BlockContent\NotionRichText;
use Pi\Notion\Core\BlockContent\NotionTextValue;
use Pi\Notion\Enums\NotionBlockContentTypeEnum;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionDatabaseTitle extends BaseNotionProperty
{
    private NotionTextValue|NotionEmptyValue $content;

    public function __construct(string $name)
    {
        parent::__construct($name);

        $this->content = NotionTextValue::make($this->name)
            ->setValueType($this->type)
            ->setContentType()
            ->buildResource();

    }

    public function setTitle(string $string): static
    {
        $this->content->text($string);

        return $this;
    }

    protected function buildValue(): NotionContent
    {
        return NotionArrayValue::make($this->content->resource)
            ->setValueType($this->type)
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
            ->setValueType($this->type);

        return $this;
    }
}
