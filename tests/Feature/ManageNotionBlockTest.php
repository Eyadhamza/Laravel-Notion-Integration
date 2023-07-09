<?php

use Pi\Notion\Core\Models\NotionBlock;
use Pi\Notion\Core\BlockContent\NotionRichText;

it('returns block info', function () {
    $block = NotionBlock::find('b1cfe8df181543039b2f9e3f2c87516c');

    expect($block)->toHaveProperty('objectType');
});

it('returns block children', function () {
    $block = NotionBlock::find('62ec21df1f9241ba9954828e0958da69');

    $paginatedObject = $block->addChildren([
        NotionBlock::headingTwo(NotionRichText::make('Eyad Hamza')
            ->bold()
            ->setLink('https://www.google.com')
            ->color('red')),
        NotionBlock::headingThree('Heading 3'),
        NotionBlock::numberedList('Numbered List'),
        NotionBlock::bulletedList('Bullet List'),
    ])->getChildren(50);

    expect($paginatedObject->getResults())->toHaveCount(50);

    $paginatedObject->next();
    expect($paginatedObject->getResults())->toHaveCount(50);

    $paginatedObject->next();
    expect($paginatedObject->getResults())->toHaveCount(50);

    $paginatedObject->next();
    expect($paginatedObject->hasMore())->toBeFalse();
});

it('updates the block', function () {
    $block = NotionBlock::headingOne('This is a paragraph')
        ->setId('b1cfe8df181543039b2f9e3f2c87516c')
        ->update();

    expect($block)->toHaveProperty('objectType');
});

it('appends block children', function () {
    $block = NotionBlock::find('62ec21df1f9241ba9954828e0958da69');

    $block = $block->addChildren([
        NotionBlock::headingTwo(NotionRichText::make('Eyad Hamza')
            ->bold()
            ->setLink('https://www.google.com')
            ->color('red')),
        NotionBlock::headingThree('Heading 3'),
        NotionBlock::numberedList('Numbered List'),
        NotionBlock::bulletedList('Bullet List'),
    ])->createChildren();

    expect($block->getResults())->toHaveCount(4);
});

it('deletes the block', function () {
    $block = NotionBlock::find('62ec21df1f9241ba9954828e0958da69');

    expect($block)->toHaveProperty('objectType');
});
