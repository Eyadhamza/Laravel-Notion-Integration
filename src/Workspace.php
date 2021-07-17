<?php

namespace Pi\Notion;

class Workspace
{
    //TODO
    // users

    const BASE_URL= 'https://api.notion.com/v1';
    const PAGE_URL = Workspace::BASE_URL.'/pages/';
    const SEARCH_PAGE_URL =  Workspace::BASE_URL.'/search';
    const DATABASE_URL = Workspace::BASE_URL.'/databases/';
    const NOTION_VERSION = '2021-05-13';

    private string $token;



    public function __construct()
    {
        $token = \config('notion-wrapper.info.token');
        $this->token = $token;
    }

    public static function workspace(): self
    {
        return new self();
    }

}
