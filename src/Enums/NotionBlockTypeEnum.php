<?php

namespace PISpace\Notion\Enums;

enum NotionBlockTypeEnum: string
{
    case PARAGRAPH = 'paragraph';
    case HEADING_1 = 'heading_1';
    case HEADING_2 = 'heading_2';
    case HEADING_3 = 'heading_3';
    case BULLETED_LIST_ITEM = 'bulleted_list_item';
    case NUMBERED_LIST_ITEM = 'numbered_list_item';
    case TO_DO = 'to_do';
    case TOGGLE = 'toggle';
    case CHILD_PAGE = 'child_page';
    case EMBED = 'embed';
    case IMAGE = 'image';
    case VIDEO = 'video';
    case FILE = 'file';
    case PDF = 'pdf';
    case BOOKMARK = 'bookmark';
    case CODE = 'code';
    case COLUMN_LIST = 'column_list';
    case COLUMN = 'column';
    case QUOTE = 'quote';
    case CALLOUT = 'callout';
    case TABLE_OF_CONTENTS = 'table_of_contents';
    case BREADCRUMB = 'breadcrumb';
    case DIVIDER = 'divider';
    case HEADER = 'header';
    case SUB_HEADER = 'sub_header';
    case SUB_SUB_HEADER = 'sub_sub_header';
    case TOC_PAGE = 'toc_page';
    case EQUATION = 'equation';
    case CHILD_DATABASE = 'child_database';
    case LINK_PREVIEW = 'link_preview';

    case PAGE = 'page';
}
