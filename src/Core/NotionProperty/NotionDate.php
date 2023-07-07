<?php

namespace Pi\Notion\Core\NotionProperty;

class NotionDate extends BaseNotionProperty
{


    public function setAttributes(): BaseNotionProperty
    {
        $this->attributes = [
            'date' => $this->value ?? new \stdClass()
        ];

        return $this;
    }
}
