<?php

namespace Pi\Notion\Core\NotionProperty;

use stdClass;

class NotionEmail extends BaseNotionProperty
{

    public function setAttributes(): BaseNotionProperty
    {
        $this->attributes = [
            'email' => $this->value ?? new stdClass(),
        ];

        return $this;
    }
}
