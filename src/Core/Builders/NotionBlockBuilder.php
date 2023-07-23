<?php

namespace PISpace\Notion\Core\Builders;


use Illuminate\Support\Collection;
use PISpace\Notion\Core\Content\NotionEmptyValue;
use PISpace\Notion\Core\Content\NotionFile;
use PISpace\Notion\Core\Content\NotionRichText;
use PISpace\Notion\Core\Content\NotionSimpleValue;
use PISpace\Notion\Enums\NotionBlockTypeEnum;

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
            ->setBlockType(NotionBlockTypeEnum::HEADING_1);

        return $this;
    }

    public function headingThree(string|NotionRichText $richText): self
    {
        $this->blocks[] = NotionRichText::getOrCreate($richText)
            ->setBlockType(NotionBlockTypeEnum::HEADING_3);

        return $this;
    }

    public function headingTwo(string|NotionRichText $richText): self
    {
        $this->blocks[] = NotionRichText::getOrCreate($richText)
            ->setBlockType(NotionBlockTypeEnum::HEADING_2);

        return $this;
    }

    public function paragraph(string|NotionRichText $richText): self
    {
        $this->blocks[] = NotionRichText::getOrCreate($richText)
            ->setBlockType(NotionBlockTypeEnum::PARAGRAPH);

        return $this;
    }

    public function toggle(string|NotionRichText $richText): self
    {
        $this->blocks[] = NotionRichText::getOrCreate($richText)
            ->setBlockType(NotionBlockTypeEnum::TOGGLE);

        return $this;
    }

    public function callout(string|NotionRichText $richText): self
    {
        $this->blocks[] = NotionRichText::getOrCreate($richText)
            ->setBlockType(NotionBlockTypeEnum::CALLOUT);

        return $this;
    }

    public function code(NotionRichText $richText): self
    {
        $this->blocks[] = NotionRichText::getOrCreate($richText)
            ->setBlockType(NotionBlockTypeEnum::CODE);

        return $this;
    }

    public function quote(string|NotionRichText $richText): self
    {
        $this->blocks[] = NotionRichText::getOrCreate($richText)
            ->setBlockType(NotionBlockTypeEnum::QUOTE);

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

    public function image(NotionFile $file): self
    {
        $this->blocks[] = $file->setBlockType(NotionBlockTypeEnum::IMAGE);

        return $this;
    }

    public function getBlocks(): Collection
    {
        return $this->blocks;
    }

    public function file(NotionFile $file): self
    {
        $this->blocks[] = $file->setBlockType(NotionBlockTypeEnum::FILE);

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


    public function pdf(NotionFile $file): self
    {
        $this->blocks[] = $file->setBlockType(NotionBlockTypeEnum::PDF);

        return $this;
    }

    public function video(NotionFile $file): self
    {
        $this->blocks[] = $file->setBlockType(NotionBlockTypeEnum::VIDEO);

        return $this;
    }


}
