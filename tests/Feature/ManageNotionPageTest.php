<?php

use Pi\Notion\Core\BlockContent\NotionFile;
use Pi\Notion\Core\BlockContent\NotionRichText;
use Pi\Notion\Core\Builders\NotionBlockBuilder;
use Pi\Notion\Core\Models\NotionPage;
use Pi\Notion\Core\Models\NotionUser;
use Pi\Notion\Core\NotionProperty\BaseNotionProperty;
use Pi\Notion\Core\NotionProperty\NotionCheckbox;
use Pi\Notion\Core\NotionProperty\NotionDate;
use Pi\Notion\Core\NotionProperty\NotionEmail;
use Pi\Notion\Core\NotionProperty\NotionFiles;
use Pi\Notion\Core\NotionProperty\NotionNumber;
use Pi\Notion\Core\NotionProperty\NotionPeople;
use Pi\Notion\Core\NotionProperty\NotionPhoneNumber;
use Pi\Notion\Core\NotionProperty\NotionRelation;
use Pi\Notion\Core\NotionProperty\NotionSelect;
use Pi\Notion\Core\NotionProperty\NotionTitle;
use Pi\Notion\Core\NotionProperty\NotionUrl;
use Pi\Notion\Core\Query\NotionPaginator;
use function Pest\Laravel\withoutExceptionHandling;

beforeEach(function () {
    withoutExceptionHandling();
    $this->databaseId = 'ae4c13cd00394938b2f7914cb00350f8';
    $this->pageId = '0ef342c64e9f431fb5cf8a9eebea4c92';
});

it('should return page info', function () {
    $page = new NotionPage($this->pageId);

    expect($page)->toHaveProperty('objectType');
});

it('should return page info with blocks', function () {
    $page = new NotionPage($this->pageId);

    expect($page)->toHaveProperty('objectType');
});

it('can create a page object', function () {
    $page = new NotionPage();
    $page->setDatabaseId($this->databaseId);
    $page->create();

    expect($page)->toHaveProperty('objectType');
});

it('can delete a page object', function () {
    $page = NotionPage::make()->delete('ec9df16fa65f4eef96776ee41ee3d4d4');

    expect($page)->toHaveProperty('objectType');
});

it('should add properties to the created page using the page class', function () {
    $page = new NotionPage();
    $page->setDatabaseId($this->databaseId);

    $page = $page
        ->setProperties([
            NotionTitle::make('Name')
                ->setTitle('Test'),
            NotionSelect::make('Status')
                ->setSelected('A'),
            NotionDate::make('Date')
                ->setStart('2021-01-01'),
            NotionCheckbox::make('Checkbox')
                ->setChecked(true),
            NotionRelation::make('Relation')
                ->setPageIds(['633fc9822c794e3682186491c50210e6']),

            NotionPeople::make('People')
                ->setPeople([
                    new NotionUser('2c4d6a4a-12fe-4ce8-a7e4-e3019cc4765f')
                ]),
            NotionFiles::make('Media')
                ->setFiles([
                    NotionFile::make('Google')
                        ->setFileType('external')
                        ->setFileUrl('https://www.google.com'),
                    NotionFile::make('Notion')
                        ->setFileType('file')
                        ->setFileUrl('https://s3.us-west-2.amazonaws.com/secure.notion-static.com/7b8b0713-dbd4-4962-b38b-955b6c49a573/My_test_image.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Credential=AKIAT73L2G45EIPT3X45%2F20221024%2Fus-west-2%2Fs3%2Faws4_request&X-Amz-Date=20221024T205211Z&X-Amz-Expires=3600&X-Amz-Signature=208aa971577ff05e75e68354e8a9488697288ff3fb3879c2d599433a7625bf90&X-Amz-SignedHeaders=host&x-id=GetObject')
                        ->setExpiryTime('2022-10-24T22:49:22.765Z'),
                ]),
            NotionEmail::make('Email')
                ->setEmail('eyadhamza0@gmail.com'),
            NotionNumber::make('Number')
                ->setNumber(10),
            NotionPhoneNumber::make('Phone')
                ->setPhoneNumber('+201010101010'),
            NotionUrl::make('Url')
                ->setUrl('https://www.google.com'),
        ])->create();

    expect($page->getProperties())->toHaveCount(17)
        ->and($page)->toHaveProperty('properties');
});

it('can update properties of the created page using the page class', function () {
    $page = NotionPage::make()->setProperties([
        NotionTitle::make('Name')
            ->setTitle('Test'),
    ])->update($this->pageId);

    expect($page)->toHaveProperty('properties');
});


it('can add content blocks to the created pages', function () {
    $page = new NotionPage();
    $page->setDatabaseId($this->databaseId);

    $page
        ->setProperties([
            NotionTitle::make('Name', 'Test'),
            NotionSelect::make('Status')
                ->setSelected('A'),
        ]);

    $page->setBlockBuilder(
        NotionBlockBuilder::make()
            ->headingOne(NotionRichText::text('Eyad Hamza')
                ->isToggleable()
                ->setChildren([
                    NotionRichText::text('Eyad Hamza')
                        ->bold()
                        ->italic()
                        ->strikethrough()
                        ->underline()
                        ->code()
                        ->color('red')
                ])
                ->bold()
                ->italic()
                ->strikethrough()
                ->underline()
                ->code()
                ->color('red')
            )
            ->headingTwo('Heading 2')
            ->headingThree('Heading 3')
        ->numberedList([
            'Numbered List',
            'asdasd Numbered List'
        ])
        ->bulletedList(['Bullet List'])
        ->paragraph('Paragraph')
        ->toDo(['To Do List'])
        ->toggle('Toggle')
        ->quote('Quote')
        ->divider()
        ->callout('Callout')
        ->childPage('Child Page')
        ->image(NotionFile::make()
            ->setFileUrl('https://www.google.com')
            ->setFileType('external')
        )
        ->file(NotionFile::make()
            ->setFileUrl('https://www.google.com')
            ->setFileType('external')
        )
        ->embed('https://www.google.com')
        ->bookmark('https://www.google.com')
        ->code('echo "Hello World"')
        ->equation('x^2 + y^2 = z^2')
        ->childDatabase('Child Database')
        ->column()
        ->columnList()
        ->linkPreview('https://www.google.com')
        ->pdf(NotionFile::make()
            ->setFileUrl('https://www.google.com')
            ->setFileType('external')
        )
        ->video(NotionFile::make()
            ->setFileUrl('https://www.google.com')
            ->setFileType('external')
        )
    )->create();
    dd($page->getBlocks());
    expect($page->getProperties())->toHaveCount(2)
        ->and($page->getBlocks())->toHaveCount(5)
        ->and($page)->toHaveProperty('properties');
});

it('can add nested content blocks to created pages', function () {
    $page = new NotionPage();
    $page->setDatabaseId($this->databaseId);

    $page->setBlockBuilder([
        NotionBlockBuilder::paragraph('Hello There im a parent of the following blocks!')
            ->addChildren([
                NotionBlockBuilder::headingTwo(NotionRichText::make('Eyad Hamza')
                    ->bold()
                    ->setLink('https://www.google.com')
                    ->color('red')),
                NotionBlockBuilder::headingThree('Heading 3'),
                NotionBlockBuilder::numberedList('Numbered List'),
                NotionBlockBuilder::bulletedList('Bullet List'),
            ]),
        NotionBlockBuilder::headingTwo('Heading 2'),
        NotionBlockBuilder::headingThree('Heading 3'),
        NotionBlockBuilder::numberedList('Numbered List'),
        NotionBlockBuilder::bulletedList('Bullet List'),
    ])->create();

    expect($page->getBlocks())->toHaveCount(5);
});

it('can add content blocks to created pages using the page class', function () {
    $page = new NotionPage();
    $page->setDatabaseId($this->databaseId);

    $page->setBlockBuilder([
        NotionBlockBuilder::paragraph('Hello There im a parent of the following blocks!')
            ->addChildren([
                NotionBlockBuilder::headingTwo(NotionRichText::make('Eyad Hamza')
                    ->bold()
                    ->setLink('https://www.google.com')
                    ->color('red')),
                NotionBlockBuilder::headingThree('Heading 3'),
                NotionBlockBuilder::numberedList('Numbered List'),
                NotionBlockBuilder::bulletedList('Bullet List'),
            ]),
        NotionBlockBuilder::headingTwo('Heading 2'),
        NotionBlockBuilder::headingThree('Heading 3'),
        NotionBlockBuilder::numberedList('Numbered List'),
        NotionBlockBuilder::bulletedList('Bullet List'),
    ])->create();

    expect($page->getBlocks())->toHaveCount(5);
});

it('returns a property by ID', function () {
    $page = NotionPage::make()->find('e20014185b654e08a6285872b0b622f9');

    $property = $page->getProperty('Text');
    expect($property)->toBeInstanceOf(NotionPaginator::class);

    $property = $page->getProperty('Status');
    expect($property)->toBeInstanceOf(BaseNotionProperty::class);
});
