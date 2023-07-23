<?php

use PISpace\Notion\Core\Content\NotionRichText;
use PISpace\Notion\Core\Builders\NotionBlockBuilder;
use PISpace\Notion\Core\Models\NotionBlock;
use PISpace\Notion\Enums\NotionBlockTypeEnum;

beforeEach(function (){
    $this->blockId = 'c89e2e6ed725407895658f0ddbeed02f';
});

it('appends block children', function () {
    $block = NotionBlock::make($this->blockId);

    $paginatedObject = $block->setBlockBuilder(
        NotionBlockBuilder::make()
            ->headingTwo(NotionRichText::text('Eyad Hamza')
                ->bold()
                ->setLink('https://www.google.com')
                ->color('red'))
            ->headingThree('Heading 3')
            ->numberedList(['Numbered List'])
            ->bulletedList(['Bullet List'])
    )->createChildren();

    expect($paginatedObject->getResults())->toHaveCount(4);
});

it('returns block info', function () {
    $block = NotionBlock::make($this->blockId)->find();

    expect($block)->toHaveProperty('objectType');
});

it('returns block children', function () {
    $block = NotionBlock::make($this->blockId)
        ->fetchChildren();

    expect($block->getResults()->count())->toBeGreaterThanOrEqual(4);
});

it('updates the block', function () {
    $block = NotionBlock::make($this->blockId)
        ->setType(NotionBlockTypeEnum::HEADING_1)
        ->setBlockContent(NotionRichText::text('Eyad Hamza'))
        ->update();

    expect($block)->toHaveProperty('objectType');
});

it('deletes the block', function () {
    $block = NotionBlock::make('287ab40e97d949299f7eb13a9f2bbdb1')->delete();

    expect($block)->toHaveProperty('objectType');
});
