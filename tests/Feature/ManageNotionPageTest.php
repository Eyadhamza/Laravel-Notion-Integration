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
use Pi\Notion\Core\NotionProperty\NotionMedia;
use Pi\Notion\Core\NotionProperty\NotionNumber;
use Pi\Notion\Core\NotionProperty\NotionPeople;
use Pi\Notion\Core\NotionProperty\NotionPhoneNumber;
use Pi\Notion\Core\NotionProperty\NotionRelation;
use Pi\Notion\Core\NotionProperty\NotionSelect;
use Pi\Notion\Core\NotionProperty\NotionText;
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
    $page = NotionPage::make('ec9df16fa65f4eef96776ee41ee3d4d4')
        ->delete();

    expect($page)->toHaveProperty('objectType');
});

it('should add properties to the created page using the page class', function () {
    $page = new NotionPage();
    $page->setDatabaseId($this->databaseId);

    $page = $page
        ->buildProperties([
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
            NotionText::make('Password')
                ->setText('Text'),
            NotionPeople::make('People')
                ->setPeople([
                    NotionUser::make('2c4d6a4a-12fe-4ce8-a7e4-e3019cc4765f'),
                ]),
            NotionMedia::make('Media')
                ->setFiles([
                    NotionFile::make()
                        ->setFileType('file')
                        ->setRelativeType('external')
                        ->setFileUrl('https://www.google.com'),
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
    $page = NotionPage::make($this->pageId)
        ->buildProperties([
            NotionTitle::make('Name')
                ->setTitle('Test'),
        ])->update();

    expect($page)->toHaveProperty('properties');
});


it('can add content blocks to the created pages', function () {
    $page = new NotionPage();
    $page->setDatabaseId($this->databaseId);

    $page
        ->buildProperties([
            NotionTitle::make('Name', 'Test'),
            NotionSelect::make('Status')
                ->setSelected('A'),
        ]);

    $page->setBlockBuilder(
        NotionBlockBuilder::make()
            ->headingOne(NotionRichText::text('Eyad Hamza')
                ->isToggleable()
                ->setChildrenBuilder(
                    NotionBlockBuilder::make()
                        ->headingOne(NotionRichText::text('Eyad Hamza')
                            ->bold()
                            ->italic()
                            ->strikethrough()
                            ->underline()
                            ->code()
                            ->color('red')
                        )
                )
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
            ->image(NotionFile::make()
                ->setFileType('image')
                ->setFileUrl('https://my.alfred.edu/zoom/_images/foster-lake.jpg')
                ->setRelativeType('external')
            )
            ->file(NotionFile::make()
                ->setFileType('file')
                ->setFileUrl('https://www.google.com')
                ->setRelativeType('external')
            )
            ->embed('https://www.google.com')
            ->bookmark('https://www.google.com')
            ->code(NotionRichText::text('echo "Hello World"')->setCodeLanguage('php'))
            ->equation('x^2 + y^2 = z^2')
//            ->column()
//            ->columnList()
            ->pdf(NotionFile::make()
                ->setFileType('pdf')
                ->setFileUrl('https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf')
                ->setRelativeType('external')
            )
            ->video(NotionFile::make()
                ->setFileType('video')
                ->setFileUrl('https://www.youtube.com/watch?v=xTQ7vhtp23w')
                ->setRelativeType('external')
            )
    )->create();

    expect($page->getBlocks())->toHaveCount(19);
});

it('returns a property by ID', function () {
    $page = NotionPage::make('e20014185b654e08a6285872b0b622f9')->find();

    $property = $page->getProperty('Text');
    expect($property)->toBeInstanceOf(NotionPaginator::class);

    $property = $page->getProperty('Status');
    expect($property)->toBeInstanceOf(BaseNotionProperty::class);
});
