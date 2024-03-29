<?php

namespace PISpace\Notion\Core\Properties;

use PISpace\Notion\Enums\NotionPropertyTypeEnum;

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

}
