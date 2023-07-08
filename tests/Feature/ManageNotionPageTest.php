<?php

use Pi\Notion\Core\Models\NotionBlock;
use Pi\Notion\Core\Models\NotionPage;
use Pi\Notion\Core\Models\NotionUser;
use Pi\Notion\Core\NotionProperty\BaseNotionProperty;
use Pi\Notion\Core\NotionProperty\NotionTitle;
use Pi\Notion\Core\NotionProperty\NotionSelect;
use Pi\Notion\Core\NotionValue\NotionRichText;
use Pi\Notion\Core\Query\NotionPaginator;
use Pi\Notion\Core\NotionProperty\NotionRollup;
use Pi\Notion\Core\NotionProperty\NotionPeople;
use Pi\Notion\Core\NotionProperty\NotionFiles;
use Pi\Notion\Core\NotionProperty\NotionEmail;
use Pi\Notion\Core\NotionProperty\NotionNumber;
use Pi\Notion\Core\NotionProperty\NotionPhoneNumber;
use Pi\Notion\Core\NotionProperty\NotionUrl;
use Pi\Notion\Core\NotionProperty\NotionCreatedTime;
use Pi\Notion\Core\NotionProperty\NotionCreatedBy;
use Pi\Notion\Core\NotionProperty\NotionLastEditedTime;
use Pi\Notion\Core\NotionProperty\NotionLastEditedBy;
use Pi\Notion\Core\NotionProperty\NotionCheckbox;
use Pi\Notion\Core\NotionProperty\NotionDate;
use Pi\Notion\Core\NotionProperty\NotionFormula;
use Pi\Notion\Core\NotionProperty\NotionRelation;
use function Pest\Laravel\withoutExceptionHandling;

beforeEach(function () {
    withoutExceptionHandling();
});

it('should return page info', function () {
    $page = new NotionPage('b4f8e429038744ca9c8d5afa93ea2edd');

    expect($page)->toHaveProperty('objectType');
});

it('should return page info with blocks', function () {
    $page = new NotionPage('b4f8e429038744ca9c8d5afa93ea2edd');

    expect($page)->toHaveProperty('objectType');
});

it('can create a page object', function () {
    $page = new NotionPage();
    $page->setDatabaseId('cd156262c1d2475c9df34b41a1d3110e');
    $page->create();

    expect($page)->toHaveProperty('objectType');
});

it('can delete a page object', function () {
    $page = (new NotionPage('ec9df16fa65f4eef96776ee41ee3d4d4'))->delete();

    expect($page)->toHaveProperty('objectType');
});

it('should add properties to the created page using the page class', function () {
    $page = new NotionPage();
    $page->setDatabaseId('cd156262c1d2475c9df34b41a1d3110e');

    $page = $page
        ->setProperties([
            NotionTitle::make('Name')
                ->setTitle('Test')
                ->build(),
            NotionSelect::make('Status')
                ->setSelected('A')
                ->build(),
            NotionDate::make('Date')
                ->setStart('2021-01-01')
                ->build(),
            NotionCheckbox::make('Checkbox')
                ->setChecked(true)
                ->build(),
            NotionRelation::make('Relation')
                ->setPageIds(['633fc9822c794e3682186491c50210e6'])
                ->build(),

            NotionPeople::make('People')
                ->setPeople([
                    new NotionUser('2c4d6a4a-12fe-4ce8-a7e4-e3019cc4765f')
                ])
                ->build(),
            NotionFiles::make('Media')
                ->setFiles([
                    new \Pi\Notion\Core\NotionValue\NotionFile(),
                    new \Pi\Notion\Core\NotionValue\NotionFile()
                ])
                ->build(),
//            NotionEmail::make('Email')->build(),
//            NotionNumber::make('Number')->build(),
//            NotionPhoneNumber::make('Phone')->build(),
//            NotionUrl::make('Url')->build(),
//            NotionCreatedTime::make('CreatedTime')->build(),
//            NotionCreatedBy::make('CreatedBy')->build(),
//            NotionLastEditedTime::make('LastEditedTime')->build(),
//            NotionLastEditedBy::make('LastEditedBy')->build(),
        ])->create();
    expect($page->getProperties())->toHaveCount(7)
        ->and($page)->toHaveProperty('properties');
});

it('can update properties of the created page using the page class', function () {
    $page = new NotionPage('687e13b1b8bb4eb9957d5843404b6d5d');
    $response = $page
        ->select('Status', 'In Progress')
        ->update();

    expect($page)->toHaveProperty('properties');
});

it('should add properties to the created page', function () {
    $page = new NotionPage();
    $page->setDatabaseId('632b5fb7e06c4404ae12065c48280e4c');

    $page->setProperties([
        BaseNotionProperty::title('Name', 'Eyad Hamza'),
        BaseNotionProperty::multiSelect('Status1', ['A', 'B']),
        BaseNotionProperty::select('Status', 'A'),
        BaseNotionProperty::date('Date', [
            'start' => '2020-12-08T12:00:00Z',
            'end' => '2020-12-08T12:00:00Z',
        ]),
        BaseNotionProperty::url('https://developers.notion.com'),
        BaseNotionProperty::email('Email', 'Eyadhamza0@outlook.com'),
        BaseNotionProperty::phone()->setValues('0123456789'),
    ])->create();

    expect($page->getProperties())->toHaveCount(7)
        ->and($page)->toHaveProperty('properties');
});

it('can add content blocks to the created pages', function () {
    $page = new NotionPage();
    $page->setDatabaseId('cd156262c1d2475c9df34b41a1d3110e');

    $page
        ->setProperties([
            NotionTitle::make('Name')
                ->setTitle('Eyad Hamza')
                ->build(),
            NotionSelect::make('Status')
                ->setSelected('A')
                ->build(),
        ]);

    $page->setBlocks([
        NotionBlock::headingOne(NotionRichText::make('Eyad Hamza')
            ->bold()
            ->italic()
            ->strikethrough()
            ->underline()
            ->code()
            ->color('red')),
        NotionBlock::headingTwo('Heading 2'),
        NotionBlock::headingThree('Heading 3'),
        NotionBlock::numberedList('Numbered List'),
        NotionBlock::bulletedList('Bullet List'),
    ]);

    expect($page->getProperties())->toHaveCount(2)
        ->and($page->getBlocks())->toHaveCount(5)
        ->and($page)->toHaveProperty('properties');
});

it('can add nested content blocks to created pages', function () {
    $page = new NotionPage();
    $page->setDatabaseId('632b5fb7e06c4404ae12065c48280e4c');

    $page
        ->title('Name', '322323')
        ->multiSelect('Status1', ['A', 'B']);

    $page->setBlocks([
        NotionBlock::paragraph('Hello There im a parent of the following blocks!')
            ->addChildren([
                NotionBlock::headingTwo(NotionRichText::make('Eyad Hamza')
                    ->bold()
                    ->setLink('https://www.google.com')
                    ->color('red')),
                NotionBlock::headingThree('Heading 3'),
                NotionBlock::numberedList('Numbered List'),
                NotionBlock::bulletedList('Bullet List'),
            ]),
        NotionBlock::headingTwo('Heading 2'),
        NotionBlock::headingThree('Heading 3'),
        NotionBlock::numberedList('Numbered List'),
        NotionBlock::bulletedList('Bullet List'),
    ]);

    $page->create();

    expect($page->getProperties())->toHaveCount(2)
        ->and($page->getBlocks())->toHaveCount(5)
        ->and($page)->toHaveProperty('properties');
});

it('can add content blocks to created pages using the page class', function () {
    $page = new NotionPage();
    $page->setDatabaseId('632b5fb7e06c4404ae12065c48280e4c');

    $page
        ->title('Name', 'Eyad Hamza')
        ->multiSelect('Status1', ['A', 'B'])
        ->headingOne('Heading 1')
        ->headingTwo('Heading 2')
        ->headingThree('Heading 3')
        ->numberedList('Numbered List')
        ->bulletedList('Bullet List')
        ->create();

    expect($page->getProperties())->toHaveCount(2)
        ->and($page->getBlocks())->toHaveCount(5)
        ->and($page)->toHaveProperty('properties');
});

it('returns a property by ID', function () {
    $page = NotionPage::find('e20014185b654e08a6285872b0b622f9');

    $property = $page->getProperty('Text');
    expect($property)->toBeInstanceOf(NotionPaginator::class);

    $property = $page->getProperty('Status');
    expect($property)->toBeInstanceOf(BaseNotionProperty::class);
});
