<?php

namespace Pi\Notion\Core\NotionProperty;

use Pi\Notion\Enums\NotionPropertyTypeEnum;

class NotionDatabaseDescription extends BaseNotionProperty
{
    public function __construct(string $name)
    {
        parent::__construct($name, $name);
    }

    public function setType(): self
    {
        $this->type = NotionPropertyTypeEnum::DESCRIPTION;

        return $this;
    }

}
