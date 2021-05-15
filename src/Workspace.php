<?php

namespace Pi\Notion;

use Illuminate\Support\Facades\Config;

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
