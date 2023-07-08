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
        $this->value = NotionRichText::make($this->name, 'text')->toResource();

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

    protected function buildValue()
    {
        // TODO: Implement buildValue() method.
    }

    protected function buildFromResponse(array $response): BaseNotionProperty
    {
        // TODO: Implement buildFromResponse() method.
    }

    public function setType(): BaseNotionProperty
    {
        // TODO: Implement setType() method.
    }
}
