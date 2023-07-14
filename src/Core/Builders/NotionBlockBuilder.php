<?php

namespace Pi\Notion\Core\Builders;

use Pi\Notion\Core\BlockContent\NotionContent;
use Pi\Notion\Core\BlockContent\NotionRichText;
use Pi\Notion\Enums\NotionBlockTypeEnum;

class NotionBlockBuilder
{


    public static function headingOne(string|NotionRichText $body): NotionContent
    {

        $body = is_string($body) ? NotionRichText::make($body)->isNested() : $body;

        return NotionContent::make(NotionBlockTypeEnum::HEADING_1, $body);
    }

    public static function headingTwo(string|NotionRichText $body): NotionContent
    {
        $body = is_string($body) ? NotionRichText::make($body)->isNested() : $body;

        return NotionContent::make(NotionBlockTypeEnum::HEADING_2, $body);
    }

    public static function headingThree(string|NotionRichText $body): NotionContent
    {
        $body = is_string($body) ? NotionRichText::make($body)->isNested() : $body;

        return NotionContent::make(NotionBlockTypeEnum::HEADING_3, $body);
    }

    public static function paragraph(string|NotionRichText $body): NotionContent
    {
        $body = is_string($body) ? NotionRichText::make($body)->isNested() : $body;

        return NotionContent::make(NotionBlockTypeEnum::PARAGRAPH, $body);
    }

    public static function bulletedList(string|NotionRichText $body): NotionContent
    {
        $body = is_string($body) ? NotionRichText::make($body)->isNested() : $body;

        return NotionContent::make(NotionBlockTypeEnum::BULLETED_LIST_ITEM, $body);
    }

    public static function numberedList(string|NotionRichText $body): NotionContent
    {
        $body = is_string($body) ? NotionRichText::make($body)->isNested() : $body;

        return NotionContent::make(NotionBlockTypeEnum::NUMBERED_LIST_ITEM, $body);
    }

    public static function toggle(string|NotionRichText $body): NotionContent
    {
        $body = is_string($body) ? NotionRichText::make($body)->isNested() : $body;

        return NotionContent::make(NotionBlockTypeEnum::TOGGLE, $body);
    }

    public static function quote(string $body): NotionContent
    {
        return NotionContent::make(NotionBlockTypeEnum::QUOTE, $body);
    }

    public static function callout(string $body): NotionContent
    {
        return NotionContent::make(NotionBlockTypeEnum::CALLOUT, $body);
    }

    public static function divider(): NotionContent
    {
        return NotionContent::make(NotionBlockTypeEnum::DIVIDER);
    }

    public static function code(string $body): NotionContent
    {
        return NotionContent::make(NotionBlockTypeEnum::CODE, $body);
    }

    public static function childPage(string $body): NotionContent
    {
        return NotionContent::make(NotionBlockTypeEnum::CHILD_PAGE, $body);
    }

    public static function embed(string $body): NotionContent
    {
        return NotionContent::make(NotionBlockTypeEnum::EMBED, $body);
    }

    public static function image(string $body): NotionContent
    {
        return NotionContent::make(NotionBlockTypeEnum::IMAGE, $body);
    }

    public static function video(string $body): NotionContent
    {
        return NotionContent::make(NotionBlockTypeEnum::VIDEO, $body);
    }

    public static function file(string $body): NotionContent
    {
        return NotionContent::make(NotionBlockTypeEnum::FILE, $body);
    }

}
