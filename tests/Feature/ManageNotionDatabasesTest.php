<?php

use Pi\Notion\Core\Models\NotionDatabase;
use Pi\Notion\Core\NotionProperty\NotionCheckbox;
use Pi\Notion\Core\NotionProperty\NotionDatabaseDescription;
use Pi\Notion\Core\NotionProperty\NotionDatabaseTitle;
use Pi\Notion\Core\NotionProperty\NotionDate;
use Pi\Notion\Core\NotionProperty\NotionFormula;
use Pi\Notion\Core\NotionProperty\NotionRelation;
use Pi\Notion\Core\NotionProperty\NotionSelect;
use Pi\Notion\Core\NotionProperty\NotionTitle;
use Pi\Notion\Core\Query\NotionFilter;
use Pi\Notion\Core\Query\NotionSort;
use Pi\Notion\Exceptions\NotionValidationException;
use function PHPUnit\Framework\assertObjectHasProperty;

it('returns database info', function () {
    $database = NotionDatabase::find('632b5fb7e06c4404ae12065c48280e4c');
    assertObjectHasProperty('objectType', $database);
});

it('can create a database object', function () {
    $database = (new NotionDatabase)
        ->setParentPageId('fa4379661ed948d7af52df923177028e')
        ->setTitle(NotionDatabaseTitle::make('Test Database')->build())
        ->setProperties([
            NotionTitle::make('Name')->build(),
            NotionSelect::make('Status')->setOptions([
                ['name' => 'A', 'color' => 'red'],
                ['name' => 'B', 'color' => 'green']
            ])->build(),
            NotionDate::make('Date')->build(),
            NotionCheckbox::make('Checkbox')->build(),
            NotionFormula::make('Formula')
                ->setExpression('prop("Name")')
                ->build(),
            NotionRelation::make('Relation')
                ->setDatabaseId('9019ee1d30c8438f9ec807be1a13f7f1')
                ->build(),
        ])
        ->create();

    assertObjectHasProperty('objectType', $database);
});

it('can update a database object', function () {
    $database = (new NotionDatabase)
        ->setDatabaseId('d930f6b04bbe42fcbfc2bf19c39f6225')
        ->setTitle(NotionDatabaseTitle::make('Test Database')->build())
        ->setDatabaseDescription(NotionDatabaseDescription::make('Test Description')->build())
        ->setProperties([
            NotionDate::make('Date')->build(),
            NotionCheckbox::make('Checkbox')->build(),
        ])
        ->update();

    assertObjectHasProperty('objectType', $database);
});

it('throws exception when database not found', function () {
    $id = '632b5fb7e06c4404ae12asdasd065c48280e4asdc';
    $this->expectException(NotionValidationException::class);
    (new NotionDatabase($id))->get();
});

it('throws exception when database not authorized', function () {
    $id = '632b5fb7e06c4404ae12065c48280e4asdc';
    $this->expectException(NotionValidationException::class);
    (new NotionDatabase($id))->get();
});

it('can filter database with one filter', function () {
    $database = new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c');
    $paginated = $database->filter(
        NotionFilter::title('Name')->contains('MMMM')
    )->query();

    expect($paginated->getResults())->toHaveCount(4);
});

it('can filter database with many filters', function () {
    $database = new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c');
    $paginated = $database->filters([
        NotionFilter::groupWithAnd([
            NotionFilter::select('Status')->equals('Reading'),
            NotionFilter::multiSelect('Status2')->contains('A'),
            NotionFilter::title('Name')->contains('MMMM')
        ])
    ])->query();
    expect($paginated->getResults())->toHaveCount(1);

    $paginated = $database->filters([
        NotionFilter::groupWithOr([
            NotionFilter::select('Status')->equals('Reading'),
            NotionFilter::multiSelect('Status2')->contains('A'),
            NotionFilter::title('Name')->contains('MMMM')
        ])
    ])->query();
    expect($paginated->getResults())->toHaveCount(4);
});

it('can filter database with nested filters', function () {
    $database = new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c');
    $paginated = $database->filters([
        NotionFilter::select('Status')
            ->equals('Reading')
            ->compoundOrGroup([
                NotionFilter::multiSelect('Status2')->contains('A'),
                NotionFilter::title('Name')->contains('MMMM')
            ], 'and')
    ])->query();
    expect($paginated->getResults())->toHaveCount(2);
});

it('can sort database results', function () {
    $database = new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c');
    $paginated = $database->sorts([
        NotionSort::property('Name')->ascending(),
    ])->filter(
        NotionFilter::title('Name')->contains('A'),
    )->query(50);
    expect($paginated->getResults())->toHaveCount(50)
        ->and($paginated->hasMore())->toBeTrue();
    $paginated->next();
    expect($paginated->getResults())->toHaveCount(50)
        ->and($paginated->getNextCursor())->toBeString();
});
