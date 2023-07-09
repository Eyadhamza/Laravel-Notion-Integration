<?php

namespace Pi\Notion\Core\NotionProperty;

use Illuminate\Http\Resources\MissingValue;
use Pi\Notion\Core\BlockContent\NotionArrayValue;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionEmptyValue;
use Pi\Notion\Core\BlockContent\NotionRichText;
use Pi\Notion\Enums\NotionBlockContentTypeEnum;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionTitle extends BaseNotionProperty
{
    private ?string $value = null;
    private NotionRichText|NotionEmptyValue $content;

    public function __construct(string $name, ?string $value = null)
    {
        parent::__construct($name);
        $this->value = $value;
        $this->setTitle($name);
    }

    public static function make(?string $name = null, ?string $value = null): static
    {
        return new self($name, $value);
    }

    public function setTitle(string $title): static
    {
        $this->name = $title;

        return $this;
    }

    protected function buildValue(): NotionContent
    {
        return NotionRichText::make($this->value)
            ->setValueType($this->type)
            ->setContentType(NotionBlockContentTypeEnum::TITLE)
            ->buildResource();

    }


    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::TITLE;

        return $this;
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        if (empty($response['title'])) {
            return $this;
        }

        $this->content = NotionRichText::make($response['title'][0]['plain_text'])
            ->setValueType($this->type);

        return $this;
    }
}
