<?php

use Pi\Notion\Core\BlockContent\NotionRichText;
use Pi\Notion\Core\Models\NotionComment;
use Pi\Notion\Enums\NotionBlockContentTypeEnum;

test('it returns all comments', function () {
    $comments = NotionComment::make('0b036890391f417cbac775e8b0bba680')->findAll();

    expect($comments->getResults())->toHaveCount(3);
});

test('it can create a comment', function () {

    $comment = NotionComment::make()
        ->setDiscussionId('ac803deb7b064cca83067c67914b02b4')
        ->setContent(NotionRichText::make('This is a comment')
            ->color('red')
            ->bold()
            ->italic()
        )
        ->create();

    $comment = NotionComment::make()
        ->setParentId('a270ab4fa945449f9284b180234b00c3')
        ->setContent('This is a comment')
        ->create();

    expect($comment)->toBeInstanceOf(NotionComment::class);
});
