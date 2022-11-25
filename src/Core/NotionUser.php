<?php

namespace Pi\Notion\Core;

class NotionUser
{
    private string $id;

    public function __construct($id = '')
    {
        $this->id = $id;
    }

}
