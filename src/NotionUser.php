<?php

namespace Pi\Notion;

class NotionUser
{
    private string $id;

    public function __construct($id = '')
    {
        $this->id = $id;
    }

}
