<?php

namespace Pi\Notion\Traits;

use Pi\Notion\Core\BlockContent\NotionRichText;
use Pi\Notion\Enums\NotionBlockTypeEnum;

trait CreateBlockTypes
{

    public function color(string $color): self
    {
        $this->color = $color;
        return $this;
    }


    public static function headingOne(string|NotionRichText $body): self
    {

        $body = is_string($body) ? NotionRichText::make($body)->isNested() : $body;

        return self::make(NotionBlockTypeEnum::HEADING_1, $body);
    }

    public static function headingTwo(string|NotionRichText $body): self
    {
        $body = is_string($body) ? NotionRichText::make($body)->isNested() : $body;

        return self::make(NotionBlockTypeEnum::HEADING_2, $body);
    }

    public static function headingThree(string|NotionRichText $body): self
    {
        $body = is_string($body) ? NotionRichText::make($body)->isNested() : $body;

        return self::make(NotionBlockTypeEnum::HEADING_3, $body);
    }

    public static function paragraph(string|NotionRichText $body): self
    {
        $body = is_string($body) ? NotionRichText::make($body)->isNested() : $body;

        return self::make(NotionBlockTypeEnum::PARAGRAPH, $body);
    }

    public static function bulletedList(string|NotionRichText $body): self
    {
        $body = is_string($body) ? NotionRichText::make($body)->isNested() : $body;

        return self::make(NotionBlockTypeEnum::BULLETED_LIST_ITEM, $body);
    }

    public static function numberedList(string|NotionRichText $body): self
    {
        $body = is_string($body) ? NotionRichText::make($body)->isNested() : $body;

        return self::make(NotionBlockTypeEnum::NUMBERED_LIST_ITEM, $body);
    }

    public static function toggle(string|NotionRichText $body): self
    {
        $body = is_string($body) ? NotionRichText::make($body)->isNested() : $body;

        return self::make(NotionBlockTypeEnum::TOGGLE, $body);
    }

    public static function quote(string $body): self
    {
        return self::make(NotionBlockTypeEnum::QUOTE, $body);
    }

    public static function callout(string $body): self
    {
        return self::make(NotionBlockTypeEnum::CALL_OUT, $body);
    }

    public static function divider(): self
    {
        return self::make(NotionBlockTypeEnum::DIVIDER);
    }

    public static function code(string $body): self
    {
        return self::make(NotionBlockTypeEnum::CODE, $body);
    }

    public static function childPage(string $body): self
    {
        return self::make(NotionBlockTypeEnum::CHILD_PAGE, $body);
    }

    public static function embed(string $body): self
    {
        return self::make(NotionBlockTypeEnum::EMBED, $body);
    }

    public static function image(string $body): self
    {
        return self::make(NotionBlockTypeEnum::IMAGE, $body);
    }

    public static function video(string $body): self
    {
        return self::make(NotionBlockTypeEnum::VIDEO, $body);
    }

    public static function file(string $body): self
    {
        return self::make(NotionBlockTypeEnum::FILE, $body);
    }

}
