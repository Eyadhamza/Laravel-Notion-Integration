<?php


namespace Pi\Notion\Tests\Setup;


use Illuminate\Support\Collection;
use Pi\Notion\ContentBlock\Block;
use Pi\Notion\ContentBlock\BlockTypes;
use Pi\Notion\NotionPage;
use Pi\Notion\Properties\DateProperty;
use Pi\Notion\Properties\MultiSelect;
use Pi\Notion\Properties\Property;
use Pi\Notion\Properties\Select;
use Pi\Notion\Properties\Title;

class NotionPageFactory
{
    private $notionPageId = '834b5c8cc1204816905cd54dc2f3341d';
    private $notionDatabaseId = '632b5fb7e06c4404ae12065c48280e4c';

    public function getAnExistingPage(): NotionPage
    {
        return (new NotionPage)->get($this->notionPageId);
    }
    public function getAnExistingPageById(): NotionPage
    {
        return  NotionPage::ofId($this->notionPageId);
    }

    public function createNotionPage()
    {
       return \Pi\Notion\Facades\NotionPage::create($this->notionDatabaseId);
    }
    public function createNotionPageWithSelectProperties(): NotionPage
    {
        $properties = new Collection();
        $page = (new NotionPage);
        $properties->add(new Title('Name','Eyad Hamza'));
        $properties->add(new Select('Status','1123','blue'));

        $page->addProperties($properties);
        return $page->create($this->notionDatabaseId);
    }

    public function createNotionPageWithMultiSelectProperties(): NotionPage
    {
        $properties = new Collection();
        $page =  (new NotionPage);
        $properties->add(new Title('Name','Eyad Hamza'));
        $properties->add((new MultiSelect('Status1','blue'))->addOptions(['A','B']));
        $properties->add(new Select('Status','1123','blue'));
        $page->addProperties($properties);
        return $page->create('632b5fb7e06c4404ae12065c48280e4c');
    }

    public function addContentToCreatedPages()
    {
        $properties = new Collection();
        $properties->add(new Title('Name','Eyad Hamza'));
        $properties->add((new MultiSelect('Status1','blue'))->addOptions(['A','B']));
        $properties->add(new Select('Status','1123','blue'));


        $blocks = new Collection();
        $block1 = $blocks->add(Block::create(BlockTypes::HEADING_1,'i want this to work!'));
        $block2 = $blocks->add(Block::create(BlockTypes::HEADING_2,'i want this to work!'));
        $block3 =$blocks->add((new Block)->ofType(BlockTypes::NUMBERED_LIST)->ofBody('i want this to work!')->createBlock());
        $block4 =$blocks->add((new Block)->ofType(BlockTypes::TODO)->ofBody('i want this to work!')->createBlock());

        $page = (new NotionPage);
        $page->addBlocks($blocks)->addProperties($properties)->create('632b5fb7e06c4404ae12065c48280e4c');

        return $page;
    }
    public function createNotionPageWithOtherTypesOfProps(): NotionPage
    {
        $properties = new Collection();
        $page =  (new NotionPage);
        $properties->add(new Title('Name','Eyad Hamza'));
        $properties->add((new MultiSelect('Status1','blue'))->addOptions(['A','B']));
        $properties->add(new Select('Status','1123','blue'));
        $properties->add(new Property(Property::PHONE,'My Phone Number','1118310451'));
        $properties->add(new Property(Property::URL_PROP,'My Url','www.something.com'));
        $properties->add(new Property(Property::EMAIL,'My Email','eyadhamza@outlook.com'));

        $page->addProperties($properties);
        return $page->create('632b5fb7e06c4404ae12065c48280e4c');
    }

    public function createNotionPageWithOtherTypesOfPropsAndDate()
    {
        $properties = new Collection();
        $page =  (new NotionPage);
        $properties->add(new Title('Name','Eyad Hamza'));
        $properties->add((new MultiSelect('Status1','blue'))->addOptions(['A','B']));
        $properties->add(new Select('Status','1123','blue'));
        $properties->add(new Property(Property::PHONE,'My Phone Number','1118310451'));
        $properties->add(new Property(Property::URL_PROP,'My Url','www.something.com'));
        $properties->add(new Property(Property::EMAIL,'My Email','eyadhamza@outlook.com'));
        $properties->add(new DateProperty(Property::DATE,'My date','2021-04-26','2021-05-07'));
        $properties->add(new DateProperty(Property::DATE,'My start date','2021-04-26'));

        $page->addProperties($properties);
        return $page->create('632b5fb7e06c4404ae12065c48280e4c');
    }
}
