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


    public function createNotionPageWithProperties(): NotionPage
    {

       return (new NotionPage)->setProperties([
            NotionPage::setTitle('Name', 'Eyad Hamza'),
            NotionPage::setMultiSelect('Status1', ['A', 'B']),
            NotionPage::setSelect('Status', 'A'),
            NotionPage::setDate('Date', [
                'start' => "2020-12-08T12:00:00Z",
                'end' => "2020-12-08T12:00:00Z",
            ]),
            NotionPage::setUrl('URL','https://developers.notion.com'),
            NotionPage::setEmail('Email','Eyadhamza0@outlook.com'),
            NotionPage::setPhone()->values('0123456789')
        ])->create($this->notionDatabaseId);
    }

    public function addContentToCreatedPages()
    {
        $properties = new Collection();
        $page = (new NotionPage);

        $properties->add(NotionPage::setTitle('Eyad Hamza'));
        $properties->add(NotionPage::setMultiSelect('Status1')
            ->multipleValues([
                ['name'  => 'A'],
                ['name' => 'B'],
                ['name' => 'C'],
            ]));

        $blocks = new Collection();
        $block1 = $blocks->add(Block::create(BlockTypes::HEADING_1, 'i want this to work!'));
        $block2 = $blocks->add(Block::create(BlockTypes::HEADING_2, 'i want this to work!'));
        $block3 = $blocks->add((new Block)->ofType(BlockTypes::NUMBERED_LIST)->ofBody('i want this to work!')->createBlock());
        $block4 = $blocks->add((new Block)->ofType(BlockTypes::TODO)->ofBody('i want this to work!')->createBlock());

        $page = (new NotionPage);
        $page
            ->addBlocks($blocks)
            ->setProperties($properties)
            ->create($this->notionDatabaseId);

        return $page;
    }
}
