<?php

namespace Pi\Notion;

class Workspace
{
    private $token;

    public function __construct()
    {

        $token = \config('notion-wrapper.info.token');
        $this->token = $token;
    }

    public static function workspace()
    {
        return new self();
    }
}
