<?php

namespace Pi\Notion\Core\Enums;

enum NotionPropertyTypeEnum: string
{
    case TITLE = 'title';
    case RICH_TEXT = 'rich_text';
    case PHONE_NUMBER = 'phone_number';

    case MULTISELECT = 'multi_select';
    case SELECT = 'select';
    case EMAIL = 'email';
    case URL = 'url';
    case CHECKBOX = 'checkbox';
    case NUMBER = 'number';
    case DATE = 'date';
    case PEOPLE = 'people';
    case FILE = 'file';
    case FORMULA = 'formula';
    case RELATION = 'relation';
    case ROLLUP = 'rollup';
    case CREATED_TIME = 'created_time';
    case LAST_EDITED_TIME = 'last_edited_time';
    case CREATED_BY = 'created_by';
    case LAST_EDITED_BY = 'last_edited_by';
    case FILES = 'files';
}
