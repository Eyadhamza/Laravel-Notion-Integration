<?php

use Pi\Notion\Core\Query\NotionSearch;
use Pi\Notion\Core\Query\NotionSort;

it('returns the search result of pages', function () {
    $response = NotionSearch::inPages('Eyad')->apply(50);

    expect($response->getResults())->toHaveCount(50);
});

it('returns the search result of databases', function () {
    $response = NotionSearch::inDatabases('test')
        ->sorts([
            NotionSort::make('last_edited_time', 'descending'),
        ])
        ->apply(50);

    expect($response->getResults()->count())->toBeGreaterThan(2);
});
