<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\BlockContent\NotionArrayValue;
use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionEmptyValue;
use Pi\Notion\Core\BlockContent\NotionRichText;
use Pi\Notion\Enums\NotionBlockContentTypeEnum;
use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionDatabaseTitle extends BaseNotionProperty
{

    public function __construct(string $name)
    {
        parent::__construct($name, $name);
    }

    public function setType(): BaseNotionProperty
    {
        $this->type = NotionPropertyTypeEnum::TITLE;

        return $this;
    }

    public function mapToResource(): array
    {
         return [
             'content' => $this->value
         ];
    }

}
