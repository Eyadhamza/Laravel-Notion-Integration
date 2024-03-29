<?php

namespace PISpace\Notion\Enums;

enum NotionBlockContentTypeEnum: string
{
    case RICH_TEXT = 'rich_text';
    case SIMPLE_VALUE = 'simple_value';
    case ARRAY_VALUE = 'array_value';
    case EMPTY_VALUE = 'empty_value';
    case FILE = 'file';
    case FORMULA = 'formula';
    case TEXT = 'text';
    case TITLE = 'title';
    case DESCRIPTION = 'description';
}
