<?php

namespace Pi\Notion\Core\NotionProperty;

use stdClass;

class NotionText extends BaseNotionProperty
{

    public function setAttributes(): BaseNotionProperty
    {
        $this->attributes = [
            'rich_text' => $this->value ?? new stdClass(),
        ];

        return $this;
    }
}
