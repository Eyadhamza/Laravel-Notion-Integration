<?php


namespace Pi\Notion\Facades;


use Illuminate\Support\Facades\Facade;

class NotionPage extends Facade
{
    protected static function getFacadeAccessor() {
        return 'notion-page';
    }
}
