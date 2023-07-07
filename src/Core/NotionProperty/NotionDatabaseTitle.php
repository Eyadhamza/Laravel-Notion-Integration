<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;

class NotionDatabaseTitle extends BaseNotionProperty
{
    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->type = NotionPropertyTypeEnum::TITLE;
    }

    public function setAttributes(): self
    {
        $this->attributes = [
            'title' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => $this->name,
                        'link' => null
                    ],
                ]
            ]
        ];

        return $this;
    }

}
