<?php

namespace Pi\Notion\Core\NotionProperty;

use stdClass;

class NotionUrl extends BaseNotionProperty
{

    public function setAttributes(): BaseNotionProperty
    {
        $this->attributes = [
            'url' => $this->value ?? new stdClass(),
        ];

        return $this;
    }
}
