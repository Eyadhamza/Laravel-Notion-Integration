<?php

use Pi\Notion\Core\Models\NotionBlock;
use Pi\Notion\Core\Models\NotionPage;
use Pi\Notion\Core\Models\NotionUser;
use Pi\Notion\Core\NotionProperty\BaseNotionProperty;
use Pi\Notion\Core\NotionProperty\NotionTitle;
use Pi\Notion\Core\NotionProperty\NotionSelect;
use Pi\Notion\Core\BlockContent\NotionFile;
use Pi\Notion\Core\BlockContent\NotionRichText;
use Pi\Notion\Core\Query\NotionPaginator;
use Pi\Notion\Core\NotionProperty\NotionPeople;
use Pi\Notion\Core\NotionProperty\NotionFiles;
use Pi\Notion\Core\NotionProperty\NotionEmail;
use Pi\Notion\Core\NotionProperty\NotionNumber;
use Pi\Notion\Core\NotionProperty\NotionPhoneNumber;
use Pi\Notion\Core\NotionProperty\NotionUrl;
use Pi\Notion\Core\NotionProperty\NotionCheckbox;
use Pi\Notion\Core\NotionProperty\NotionDate;
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
            NotionTitle::make('Name', 'Test')
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
                    NotionFile::make('Google')
                        ->setFileType('external')
                        ->setFileUrl('https://www.google.com'),
                    NotionFile::make('Notion')
                        ->setFileType('file')
                        ->setFileUrl('https://s3.us-west-2.amazonaws.com/secure.notion-static.com/7b8b0713-dbd4-4962-b38b-955b6c49a573/My_test_image.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Credential=AKIAT73L2G45EIPT3X45%2F20221024%2Fus-west-2%2Fs3%2Faws4_request&X-Amz-Date=20221024T205211Z&X-Amz-Expires=3600&X-Amz-Signature=208aa971577ff05e75e68354e8a9488697288ff3fb3879c2d599433a7625bf90&X-Amz-SignedHeaders=host&x-id=GetObject')
                        ->setExpiryTime('2022-10-24T22:49:22.765Z'),
                ])
                ->build(),
            NotionEmail::make('Email')
                ->setEmail('eyadhamza0@gmail.com')
                ->build(),
            NotionNumber::make('Number')
                ->setNumber(10)
                ->build(),
            NotionPhoneNumber::make('Phone')
                ->setPhoneNumber('+201010101010')
                ->build(),
            NotionUrl::make('Url')
                ->setUrl('https://www.google.com')
                ->build(),
        ])->create();
    expect($page->getProperties())->toHaveCount(17)
        ->and($page)->toHaveProperty('properties');
});

it('can update properties of the created page using the page class', function () {
    $page = new NotionPage('894dbb5e59ce40efac3ce60a4bb65d27');
    $page = $page
        ->setProperties([
            NotionTitle::make('Name', 'Test')
                ->build(),
        ])->update();

    expect($page)->toHaveProperty('properties');
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
    ])->create();

    expect($page->getBlocks())->toHaveCount(5);
});

it('can add content blocks to created pages using the page class', function () {
    $page = new NotionPage();
    $page->setDatabaseId('5a30faaeb526436f98b6a8e1d05f5605');

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
    ])->create();

    expect($page->getBlocks())->toHaveCount(5);
});

it('returns a property by ID', function () {
    $page = NotionPage::find('e20014185b654e08a6285872b0b622f9');

    $property = $page->getProperty('Text');
    expect($property)->toBeInstanceOf(NotionPaginator::class);

    $property = $page->getProperty('Status');
    expect($property)->toBeInstanceOf(BaseNotionProperty::class);
});
