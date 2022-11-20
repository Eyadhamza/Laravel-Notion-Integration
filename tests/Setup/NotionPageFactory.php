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
    private $notionPageId = '819f5b54348f463580ef118b6a54bd0d';
    private $notionDatabaseId = '632b5fb7e06c4404ae12065c48280e4c';

    public function getAnExistingPage(): NotionPage
    {
        return (new NotionPage)->get('c66f166ec9cf466baa3321d26aceed08');
    }

    public function getAnExistingPageById(): NotionPage
    {
        return NotionPage::ofId('c66f166ec9cf466baa3321d26aceed08');
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

        $blocks = new Collection();
        $block1 = $blocks->add(Block::create(BlockTypes::HEADING_1, 'i want this to work!'));
        $block2 = $blocks->add(Block::create(BlockTypes::HEADING_2, 'i want this to work!'));
        $block3 = $blocks->add((new Block)->ofType(BlockTypes::NUMBERED_LIST)->ofBody('i want this to work!')->createBlock());
        $block4 = $blocks->add((new Block)->ofType(BlockTypes::TODO)->ofBody('i want this to work!')->createBlock());

        $page
            ->addBlocks($blocks)
            ->create();

        return $page;
    }
}
