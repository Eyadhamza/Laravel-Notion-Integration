<?php

namespace PISpace\Notion\Enums;

enum NotionPaginatedObjectTypeEnum: string
{
    case BLOCK = 'block';
    case COMMENT = 'comment';
    case DATABASE = 'database';
    case PAGE = 'page';
    case PAGE_OR_DATABASE = 'page_or_database';
    case PROPERTY_ITEM = 'property_item';
    case USER = 'user';
}
