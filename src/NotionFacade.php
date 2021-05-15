<?php

namespace Pi\Notion;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Pi\Notion\Notion
 */
class NotionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'notionlaravelwrapper';
    }
}
