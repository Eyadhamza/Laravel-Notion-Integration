<?php

namespace Pi\Notion\Tests\Featured;

use Illuminate\Support\Collection;
use Pi\Notion\ContentBlock\Block;
use Pi\Notion\ContentBlock\BlockTypes;
use Pi\Notion\NotionDatabase;

use Pi\Notion\Exceptions\NotionDatabaseException;
use Pi\Notion\NotionPage;
use Pi\Notion\Properties\MultiSelect;
use Pi\Notion\Properties\Select;
use Pi\Notion\Properties\Title;
use Pi\Notion\Tests\TestCase;
use Pi\Notion\Workspace;

class ManageNotionPageTest extends TestCase
{

    /** @test */
    public function it_should_return_page_info()
    {
        $object = (new NotionPage)->get('834b5c8cc1204816905cd54dc2f3341d');


        $this->assertObjectHasAttribute('properties',$object);


        $object = NotionPage::ofId('834b5c8cc1204816905cd54dc2f3341d');


        $this->assertObjectHasAttribute('properties',$object);

    }

    /** @test */
    public function i_can_create_a_page_object()
    {
        $page = \Pi\Notion\Facades\NotionPage::create('632b5fb7e06c4404ae12065c48280e4c');

        $this->assertObjectHasAttribute('type',$page);

    }
    /** @test */
    public function it_should_add_select_properties_to_created_page_and_option()
    {

        $properties = new Collection();
        $page = (new NotionPage);
        $properties->add(new Title('Name','Eyad Hamza'));
        $properties->add(new Select('Status','1123','blue'));

        $page->addProperties($properties);
        $page =  $page->create('632b5fb7e06c4404ae12065c48280e4c');

        $this->assertCount(2,$page->getProperties());
        $this->assertObjectHasAttribute('properties',$page);


    }
    /** @test */
    public function it_should_add_multiselect_properties_to_created_page_and_option()
    {

        $properties = new Collection();
        $page =  (new NotionPage);
        $properties->add(new Title('Name','Eyad Hamza'));
        $properties->add((new MultiSelect('Status1','blue'))->addOptions(['A','B']));

        $properties->add(new Select('Status','1123','blue'));
        $page->addProperties($properties);
        $page->create('632b5fb7e06c4404ae12065c48280e4c',$properties);

        $this->assertCount(3,$page->getProperties());
        $this->assertObjectHasAttribute('properties',$page);


    }
    /** @test */
    public function it_can_add_content_blocks_to_created_pages()
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



        $this->assertCount(3,$page->getProperties());
        $this->assertCount(4,$page->getBlocks());
        $this->assertObjectHasAttribute('properties',$page);


    }
    /** @test */
    public function it_returns_search_result()
    {
        $page = (new NotionPage)
            ->search('New Media Article');

        $this->assertStringContainsString('list',$page['object']);
    }



}
