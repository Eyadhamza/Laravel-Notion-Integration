<?php

namespace Pi\Notion\Tests\Featured;

use Illuminate\Support\Collection;
use Pi\Notion\NotionDatabase;

use Pi\Notion\Exceptions\NotionDatabaseException;
use Pi\Notion\NotionPage;
use Pi\Notion\Properties\MultiSelect;
use Pi\Notion\Properties\Select;
use Pi\Notion\Tests\TestCase;
use Pi\Notion\Workspace;

class NotionApiTest extends TestCase
{
    /** @test */
    public function it_should_return_database_info()
    {
        $response =  (new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c'))->get();


        $this->assertStringContainsString('database',$response['object']);

        $response =  (new NotionDatabase)->get('632b5fb7e06c4404ae12065c48280e4c');

        $this->assertStringContainsString('database',$response['object']);

        $this->assertStringNotContainsString('error',$response['object']);
    }

    /** @test */
    public function it_should_throw_exception_database_not_found()
    {
        $id = '632b5fb7e06c4404ae12asdasd065c48280e4asdc';

        $this->expectException(NotionDatabaseException::class);

        $response =  (new NotionDatabase($id))->get();


    }
    /** @test */
    public function it_should_throw_exception_database_not_authorized()
    {
        $id = '632b5fb7e06c4404ae12065c48280e4asdc';

        $this->expectException(NotionDatabaseException::class);
        (new NotionDatabase($id))->get();


    }
    /** @test */
    public function it_should_return_database_contents_with_single_query()
    {

        $property = new Select('Status','Reading');

        $response =  (new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c'))->getContents($property);


        $this->assertStringContainsString('list',$response['object']);

    }

    /** @test */
    public function it_should_return_database_contents_with_multiple_query()
    {


        $properties = new Collection();
        $properties->add(new Select('Status','Reading'))
                ->add(new Select('Publisher','NYT'));


        $response =  (new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c' ))->getContents($properties,filterType: 'and');


        $this->assertStringContainsString('list',$response['object']);

    }
    /** @test */
    public function it_should_return_database_contents_with_multiple_query_multi_select_property()
    {


        $properties = new Collection();
        $properties->add(new MultiSelect('StatusMulti','a'));


        $response =  (new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c' ))->getContents($properties,filterType: 'and');


        $this->assertStringContainsString('list',$response['object']);

    }
    /** @test */
    public function it_should_return_page_info()
    {
        $object = (new NotionPage)->get('834b5c8cc1204816905cd54dc2f3341d');


        $this->assertStringContainsString('page',$object['object']);


        $object = NotionPage::ofId('834b5c8cc1204816905cd54dc2f3341d');


        $this->assertStringContainsString('page',$object['object']);

    }

    /** @test */
    public function it_should_add_properties_to_created_page()
    {
        $properties = array(
            [
            'name' => 'Name',
            'type' => 'text',
            'content' => 'New Media Article',
            ],
            [
                'name' => 'Status',
                'type' => 'select',
                'select_name' => 'Ready to Start',
                'color' => 'yellow'
            ],
            [
                'name' => 'Publisher',
                'type' => 'select',

                'select_name' => 'The Atlantic',
                'color' => 'red',
            ]);


        $response =  (new NotionPage)->create('632b5fb7e06c4404ae12065c48280e4c',$properties);


        $this->assertStringContainsString('page',$response['object']);


    }
    /** @test */
    public function it_should_add_properties_and_content_to_created_page()
    {
        $properties = array([
            'name' => 'Name',
            'type' => 'text',
            'content' => 'New Media Article',
        ],
        [
            'name' => 'Status',
            'type' => 'select',
            'select_name' => 'Ready to Start',
            'color' => 'yellow'
        ],
        [
        'name' => 'Publisher',
        'type' => 'select',

        'select_name' => 'The Atlantic',
        'color' => 'red',
        ]);
        $content=array(
            [
            'tag_type' => 'heading_2',
            'content_type' => 'text',
            'content' => 'this is my content'
            ],
            [
            'tag_type' => 'paragraph',
            'content_type' => 'text',
            'content' => 'this is my content paragraph'
        ]);

        $response =  (new NotionPage('819f5b54348f463580ef118b6a54bd0d'))
            ->create('632b5fb7e06c4404ae12065c48280e4c',$properties,$content);


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
    public function it_can_get_page_blocks()
    {

        $page =  (new NotionPage('834b5c8cc1204816905cd54dc2f3341d'))->getBlocks();

        $this->assertStringContainsString('list',$page['object']);
    }

}
