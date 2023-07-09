<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionArrayValue;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionRichText;
use Pi\Notion\Enums\NotionBlockContentTypeEnum;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionDatabaseDescription extends BaseNotionProperty
{
    private ?string $title = null;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->title = $name;
    }

    public function setType(): self
    {
        $this->type = NotionPropertyTypeEnum::DESCRIPTION;

        return $this;
    }

    public function mapToResource(): array
    {
        return [
            'content' => $this->title,
        ];
    }
}
