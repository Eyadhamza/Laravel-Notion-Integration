<?php

namespace Pi\Notion;

abstract class PropertyType
{

    const TITLE = 'title';
    const MULTISELECT = 'multi_select';
    const SELECT = 'select';
    const PHONE = 'phone_number';
    const EMAIL = 'email';
    const URL = 'url';
    const CHECKBOX = 'checkbox';
    const NUMBER = 'number';
    const DATE = 'date';
    const PEOPLE = 'people';
    const FILE = 'file';
    const FORMULA = 'formula';
    const RELATION = 'relation';
    const ROLLUP = 'rollup';
    const CREATED_TIME = 'created_time';
    const LAST_EDITED_TIME = 'last_edited_time';
    const CREATED_BY = 'created_by';
    const LAST_EDITED_BY = 'last_edited_by';
    const RICH_TEXT = 'rich_text';
}
