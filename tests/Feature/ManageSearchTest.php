<?php

use Pi\Notion\Core\Properties\NotionLastEditedTime;
use Pi\Notion\Core\Query\NotionSearch;

it('returns the search result of pages', function () {
    $response = NotionSearch::inPages('Eyad')->apply(50);

    expect($response->getResults())->toHaveCount(50);
});

it('returns the search result of databases', function () {
    $response = NotionSearch::inDatabases('test')
        ->setSorts([
            NotionLastEditedTime::make()->ascending(),
        ])
        ->apply(50);

    expect($response->getResults()->count())->toBeGreaterThan(2);
});
