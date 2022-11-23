<?php


namespace Pi\Notion\Tests\Setup;


use Illuminate\Support\Collection;
use Pi\Notion\Block;
use Pi\Notion\BlockTypes;
use Pi\Notion\NotionPage;
use Pi\Notion\Properties\DateProperty;
use Pi\Notion\Properties\MultiSelect;
use Pi\Notion\Properties\Select;
use Pi\Notion\Properties\Title;
use Pi\Notion\Property;
use Pi\Notion\PropertyType;

class NotionPageFactory
{
    private string $notionPageId = '819f5b54348f463580ef118b6a54bd0d';
    private string $notionDatabaseId = '632b5fb7e06c4404ae12065c48280e4c';

    public function getAnExistingPage()
    {
        return (new NotionPage)->get('819f5b54348f463580ef118b6a54bd0d');
    }
    public function createNotionPage()
    {
        return \Pi\Notion\Facades\NotionPage::create($this->notionDatabaseId);
    }


    public function createNotionPageWithPropertiesUsingPropertyClass(): NotionPage
    {
        $page = new NotionPage();
        $page->setDatabaseId($this->notionDatabaseId);

       return $page->setProperties([
            Property::title('Name', 'Eyad Hamza'),
            Property::multiSelect('Status1', ['A', 'B']),
            Property::select('Status', 'A'),
            Property::date('Date', [
                'start' => "2020-12-08T12:00:00Z",
                'end' => "2020-12-08T12:00:00Z",
            ]),
            Property::url('Url','https://developers.notion.com'),
            Property::email('Email','Eyadhamza0@outlook.com'),
            Property::phone()->values('0123456789')
        ])->create();
    }
    public function createNotionPageWithPropertiesUsingPage(): NotionPage
    {
        $page = new NotionPage();
        $page->setDatabaseId($this->notionDatabaseId);

       return $page
            ->title('Name','Eyad Hamza')
            ->select('Status', 'A')
            ->multiSelect('Status1', ['A', 'B'])
            ->date('Date', [
                'start' => "2020-12-08T12:00:00Z",
                'end' => "2020-12-08T12:00:00Z",
            ])->email('Email', 'eyad@outlook.com')
            ->phone('Phone', '123456789')
            ->url('Url', 'https://www.google.com')
            ->create();

    }
    public function addContentToCreatedPages()
    {
        $page = (new NotionPage);
        $page->setDatabaseId($this->notionDatabaseId);

        $page
            ->title('Name','Eyad Hamza')
            ->multiSelect('Status1', ['A', 'B']);

        $page->setBlocks([
            Block::headingOne('Heading 1'),
            Block::headingTwo('Heading 2'),
            Block::headingThree('Heading 3'),
            Block::numberedList('Numbered List'),
            Block::bulletedList('Bullet List'),
        ]);

        $page->create();

        return $page;
    }
    public function addContentToCreatedPagesUsingPageClass()
    {
        $page = (new NotionPage);
        $page->setDatabaseId($this->notionDatabaseId);

        $page
            ->title('Name','Eyad Hamza')
            ->multiSelect('Status1', ['A', 'B']);

        $page
            ->headingOne('Heading 1')
            ->headingTwo('Heading 2')
            ->headingThree('Heading 3')
            ->numberedList('Numbered List')
            ->bulletedList('Bullet List');


        $page->create();

        return $page;
    }
}
