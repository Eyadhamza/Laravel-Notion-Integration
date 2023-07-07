<?php

namespace Pi\Notion\Core\Builders;

use Pi\Notion\Core\NotionProperty\NotionDatabaseTitle;
use Pi\Notion\Core\NotionProperty\NotionDate;
use Pi\Notion\Core\NotionProperty\NotionSelect;
use Pi\Notion\Core\NotionProperty\NotionTitle;

class NotionPropertyBuilder
{

    public static function title(string $name = 'Title')
    {
        return NotionTitle::make($name)->setAttributes();
    }

    public static function select(string $name = 'Select')
    {
        return NotionSelect::make($name)->setAttributes();
    }

    public static function date(string $name = 'Date')
    {
        return NotionDate::make($name)->setAttributes();
    }

    public static function databaseTitle(string $value)
    {
        return NotionDatabaseTitle::make($value)->setAttributes();
    }
}
