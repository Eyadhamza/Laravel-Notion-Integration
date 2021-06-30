<?php

namespace Pi\Notion\Tests\Featured;

use Illuminate\Support\Collection;
use Pi\Notion\ContentBlock\Block;
use Pi\Notion\NotionDatabase;

use Pi\Notion\Exceptions\NotionDatabaseException;
use Pi\Notion\NotionPage;
use Pi\Notion\Properties\MultiSelect;
use Pi\Notion\Properties\Property;
use Pi\Notion\Properties\Select;
use Pi\Notion\Properties\Title;
use Pi\Notion\Tests\TestCase;
use Pi\Notion\Workspace;

class ManagePagesTest extends TestCase
{
    /** @test */
    public function it_should_return_page_info()
    {
        $object = (new NotionPage)->get('834b5c8cc1204816905cd54dc2f3341d');


        $this->assertStringContainsString('page',$object['object']);


        $object = NotionPage::ofId('834b5c8cc1204816905cd54dc2f3341d');


        $this->assertStringContainsString('page',$object['object']);

    }

    /** @test */
    public function it_should_add_select_properties_to_created_page_and_option()
    {

        $properties = new Collection();

        $properties->add(new Title('Name','Eyad Hamza'));
        $properties->add(new Select('Status','1123','blue'));

        $response =  (new NotionPage)->create('632b5fb7e06c4404ae12065c48280e4c',$properties);


        $this->assertStringContainsString('page',$response['object']);


    }
    /** @test */
    public function it_should_add_multiselect_properties_to_created_page_and_option()
    {

        $properties = new Collection();

        $properties->add(new Title('Name','Eyad Hamza'));
        $properties->add((new MultiSelect('StatusMulti','blue'))->addOptions(['A','B']));

        $properties->add(new Select('Status','1123','blue'));
        $response =  (new NotionPage)->create('632b5fb7e06c4404ae12065c48280e4c',$properties);


        $this->assertStringContainsString('page',$response['object']);


    }
    /** @test */
    public function it_can_add_content_blocks_to_created_pages()
    {
        $properties = new Collection();

        $properties->add(new Title('Name','Eyad Hamza'));
        $properties->add((new MultiSelect('StatusMulti','blue'))->addOptions(['A','B']));

        $properties->add(new Select('Status','1123','blue'));


        $page = (new NotionPage);
        $block1 = Block::create('heading_1','i want this to work!');
        $page->addBlock($block1);
        $block2 = Block::create('heading_1','i want this to work!');
        $page->addBlock($block2);

        $block3 =(new Block)->ofType('heading_1')->ofBody('i want this to work!')->createBlock();

        $page->addBlock($block3);

        $block3 =(new Block)->ofType('to_do')->ofBody('i want this to work!')->createBlock();

        $page->addBlock($block3);


        $response =  $page->create('632b5fb7e06c4404ae12065c48280e4c',$properties);
        dd($response);
        $this->assertStringContainsString('page',$response['object']);

    }
    /** @test */
    public function it_returns_search_result()
    {
        $response = (new NotionPage)
            ->search('New Media Article');

        $this->assertStringContainsString('list',$response['object']);
    }

    /** @test */
// TODO
//    public function it_can_get_page_blocks()
//    {
//
//        $page =  (new NotionPage('834b5c8cc1204816905cd54dc2f3341d'))->getBlocks();
//
//        $this->assertStringContainsString('list',$page['object']);
//    }
}
