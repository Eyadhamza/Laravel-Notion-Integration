<?php

namespace Pi\Notion\Core\Builders;


use Illuminate\Support\Collection;
use Pi\Notion\Core\BlockContent\NotionEmptyValue;
use Pi\Notion\Core\BlockContent\NotionFile;
use Pi\Notion\Core\BlockContent\NotionRichText;
use Pi\Notion\Core\BlockContent\NotionSimpleValue;
use Pi\Notion\Enums\NotionBlockTypeEnum;

class NotionBlockBuilder
{

    private Collection $blocks;

    public function __construct()
    {
        $this->blocks = collect();
    }

    public static function make(): static
    {
        return new static();
    }

    public function headingOne(string|NotionRichText $richText): self
    {
        $this->blocks[] = NotionRichText::getOrCreate($richText)
            ->setValueType(NotionBlockTypeEnum::HEADING_1);

        return $this;
    }

    public function headingThree(string|NotionRichText $richText): self
    {
        $this->blocks[] = NotionRichText::getOrCreate($richText)
            ->setValueType(NotionBlockTypeEnum::HEADING_3);

        return $this;
    }

    public function headingTwo(string|NotionRichText $richText): self
    {
        $this->blocks[] = NotionRichText::getOrCreate($richText)
            ->setValueType(NotionBlockTypeEnum::HEADING_2);

        return $this;
    }

    public function paragraph(string|NotionRichText $richText): self
    {
        $this->blocks[] = NotionRichText::getOrCreate($richText)
            ->setValueType(NotionBlockTypeEnum::PARAGRAPH);

        return $this;
    }

    public function toggle(string|NotionRichText $richText): self
    {
        $this->blocks[] = NotionRichText::getOrCreate($richText)
            ->setValueType(NotionBlockTypeEnum::TOGGLE);

        return $this;
    }

    public function callout(string|NotionRichText $richText): self
    {
        $this->blocks[] = NotionRichText::getOrCreate($richText)
            ->setValueType(NotionBlockTypeEnum::CALLOUT);

        return $this;
    }

    public function code(string|NotionRichText $richText): self
    {
        $this->blocks[] = NotionRichText::getOrCreate($richText)
            ->setValueType(NotionBlockTypeEnum::CODE);

        return $this;
    }

    public function quote(string|NotionRichText $richText): self
    {
        $this->blocks[] = NotionRichText::getOrCreate($richText)
            ->setValueType(NotionBlockTypeEnum::QUOTE);

        return $this;
    }

    public function numberedList(array $items): self
    {
        $this->blocks[] = NotionRichText::collection($items, NotionBlockTypeEnum::NUMBERED_LIST_ITEM);

        return $this;
    }

    public function bulletedList(array $items): self
    {
        $this->blocks[] = NotionRichText::collection($items, NotionBlockTypeEnum::BULLETED_LIST_ITEM);

        return $this;
    }

    public function toDo(array $items): self
    {
        $this->blocks[] = NotionRichText::collection($items, NotionBlockTypeEnum::TO_DO);

        return $this;
    }

    public function divider(): self
    {
        $this->blocks[] = NotionEmptyValue::make(NotionBlockTypeEnum::DIVIDER);

        return $this;
    }

    public function childPage(string $value): self
    {
        $this->blocks[] = NotionSimpleValue::make(NotionBlockTypeEnum::CHILD_PAGE, $value, 'title');

        return $this;
    }

    public function image(NotionFile $file): self
    {
        $this->blocks[] = $file->setValueType(NotionBlockTypeEnum::IMAGE);

        return $this;
    }

    public function getBlocks(): Collection
    {
        return $this->blocks;
    }

    public function file(NotionFile $file): self
    {
        $this->blocks[] = $file->setValueType(NotionBlockTypeEnum::FILE);

        return $this;
    }

    public function embed(string $value): self
    {
        $this->blocks[] = NotionSimpleValue::make(NotionBlockTypeEnum::EMBED, $value, 'url');

        return $this;
    }

    public function bookmark(string $value): self
    {
        $this->blocks[] = NotionSimpleValue::make(NotionBlockTypeEnum::BOOKMARK, $value, 'url');

        return $this;
    }

    public function equation(string $value): self
    {
        $this->blocks[] = NotionSimpleValue::make(NotionBlockTypeEnum::EQUATION, $value, 'expression');

        return $this;
    }

    public function childDatabase(string $value): self
    {
        $this->blocks[] = NotionSimpleValue::make(NotionBlockTypeEnum::CHILD_DATABASE, $value, 'title');

        return $this;
    }

    public function column(): self
    {
        $this->blocks[] = NotionEmptyValue::make(NotionBlockTypeEnum::COLUMN);

        return $this;
    }

    public function columnList(): self
    {
        $this->blocks[] = NotionEmptyValue::make(NotionBlockTypeEnum::COLUMN_LIST);

        return $this;
    }

    public function linkPreview(string $value): self
    {
        $this->blocks[] = NotionSimpleValue::make(NotionBlockTypeEnum::LINK_PREVIEW, $value, 'url');

        return $this;
    }

    public function pdf(NotionFile $file): self
    {
        $this->blocks[] = $file->setValueType(NotionBlockTypeEnum::PDF);

        return $this;
    }

    public function video(NotionFile $file): self
    {
        $this->blocks[] = $file->setValueType(NotionBlockTypeEnum::VIDEO);

        return $this;
    }


}
