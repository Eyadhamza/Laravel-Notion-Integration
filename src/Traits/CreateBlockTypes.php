<?php

namespace Pi\Notion\Traits;

use Pi\Notion\BlockType;
use Pi\Notion\Common\NotionRichText;

trait CreateBlockTypes
{

    public function color(string $color): self
    {
        $this->color = $color;
        return $this;
    }


    public static function headingOne(string|NotionRichText $body): self
    {

        $body = is_string($body) ? NotionRichText::make($body) : $body;

        return self::make(BlockType::HEADING_1, $body);
    }

    public static function headingTwo(string|NotionRichText $body): self
    {
        $body = is_string($body) ? NotionRichText::make($body) : $body;

        return self::make(BlockType::HEADING_2, $body);
    }

    public static function headingThree(string|NotionRichText $body): self
    {
        $body = is_string($body) ? NotionRichText::make($body) : $body;

        return self::make(BlockType::HEADING_3, $body);
    }

    public static function paragraph(string|NotionRichText $body): self
    {
        $body = is_string($body) ? NotionRichText::make($body) : $body;

        return self::make(BlockType::PARAGRAPH, $body);
    }

    public static function bulletedList(string|NotionRichText $body): self
    {
        $body = is_string($body) ? NotionRichText::make($body) : $body;

        return self::make(BlockType::BULLETED_LIST, $body);
    }

    public static function numberedList(string|NotionRichText $body): self
    {
        $body = is_string($body) ? NotionRichText::make($body) : $body;

        return self::make(BlockType::NUMBERED_LIST, $body);
    }

    public static function toggle(string|NotionRichText $body): self
    {
        $body = is_string($body) ? NotionRichText::make($body) : $body;

        return self::make(BlockType::TOGGLE, $body);
    }

    public static function quote(string $body): self
    {
        return self::make(BlockType::QUOTE, $body);
    }

    public static function callout(string $body): self
    {
        return self::make(BlockType::CALL_OUT, $body);
    }

    public static function divider(): self
    {
        return self::make(BlockType::DIVIDER);
    }

    public static function code(string $body): self
    {
        return self::make(BlockType::CODE, $body);
    }

    public static function childPage(string $body): self
    {
        return self::make(BlockType::CHILD_PAGE, $body);
    }

    public static function embed(string $body): self
    {
        return self::make(BlockType::EMBED, $body);
    }

    public static function image(string $body): self
    {
        return self::make(BlockType::IMAGE, $body);
    }

    public static function video(string $body): self
    {
        return self::make(BlockType::VIDEO, $body);
    }

    public static function file(string $body): self
    {
        return self::make(BlockType::FILE, $body);
    }

}