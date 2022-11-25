<?php

namespace Pi\Notion;

class NotionWorkspace
{
    //TODO
    // users

    const BASE_URL= 'https://api.notion.com/v1';
    const PAGE_URL = NotionWorkspace::BASE_URL.'/pages/';
    const BLOCK_URL = NotionWorkspace::BASE_URL.'/blocks/';
    const SEARCH_PAGE_URL =  NotionWorkspace::BASE_URL.'/search';
    const DATABASE_URL = NotionWorkspace::BASE_URL.'/databases/';
    const NOTION_VERSION = '2022-02-22';

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
