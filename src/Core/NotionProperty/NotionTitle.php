<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Core\Enums\NotionPropertyTypeEnum;
use stdClass;

class NotionTitle extends BaseNotionProperty
{

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->type = NotionPropertyTypeEnum::TITLE;
    }

    public function setAttributes(): self
    {
        if (empty($this->getValue())) {
            $this->attributes = [
                'title' => new stdClass()
            ];
            return $this;
        }

        $this->attributes = [
            'id' => 'title',
            'type' => 'title',
            'title' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => $this->getValue(),
                        'link' => null
                    ],
                    'annotations' => [
                        'bold' => false,
                        'italic' => false,
                        'strikethrough' => false,
                        'underline' => false,
                        'code' => false,
                        'color' => 'default'
                    ],
                    'plain_text' => 'Bug bash',
                    'href' => null
                ]
            ]
        ];

        return $this;
    }

    public function setValue(mixed $value): self
    {
        $this->value = $value;
        $this->setAttributes();
        return $this;
    }
}
