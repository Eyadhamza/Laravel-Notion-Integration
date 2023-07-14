<?php

namespace Pi\Notion\Core\Builders;

use Pi\Notion\Core\Query\NotionFilter;

class NotionFilterBuilder
{
    public static function select(string $propertyName): NotionFilter
    {
        return NotionFilter::make('select', $propertyName);
    }

    public static function title(string $propertyName): NotionFilter
    {
        return NotionFilter::make('title', $propertyName);
    }

    public static function text(string $propertyName): NotionFilter
    {
        return NotionFilter::make('rich_text', $propertyName);
    }
    public static function multiSelect(string $propertyName): NotionFilter
    {
        return NotionFilter::make('multi_select', $propertyName);
    }

}
