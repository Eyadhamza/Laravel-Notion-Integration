<?php

namespace Pi\Notion\Core\NotionProperty;

use stdClass;

class NotionMultiSelect extends BaseNotionProperty
{

    public function setAttributes(): BaseNotionProperty
    {
        $this->attributes = [
            'multi_select' => $this->value ?? new stdClass(),
        ];

        return $this;
    }
}
