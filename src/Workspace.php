<?php

namespace Pi\Notion;

class Workspace
{
    //TODO users
    protected $token;
    public string $BASE_URL= 'https://api.notion.com/v1';
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
