<?php

namespace PISpace\Notion\Core\Properties;

use PISpace\Notion\Enums\NotionPropertyTypeEnum;

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
