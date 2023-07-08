<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use Pi\Notion\Core\NotionValue\NotionRichText;

class NotionDatabaseDescription extends BaseNotionProperty
{

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->type = NotionPropertyTypeEnum::TITLE;
    }

    public function setValue(): self
    {
        $this->value = NotionRichText::make($this->name, 'text')->toArray();

        return $this;
    }

    public function toArray(): array
    {
        return [
            'description' => [
                [
                    $this->value
                ]
            ]
        ];
    }
}
