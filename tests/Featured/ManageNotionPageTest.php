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
use Facades\Pi\Notion\Tests\Setup\NotionPageFactory;
use Pi\Notion\Tests\TestCase;
use Pi\Notion\Workspace;

class ManageNotionPageTest extends TestCase
{


    /** @test */
    public function it_should_return_page_info()
    {
        $object = NotionPageFactory::getAnExistingPage();
        $this->assertObjectHasAttribute('properties',$object);
        $object =NotionPageFactory::getAnExistingPageById();
        $this->assertObjectHasAttribute('properties',$object);

    }

    /** @test */
    public function i_can_create_a_page_object()
    {
        $page = NotionPageFactory::createNotionPage();
        $this->assertObjectHasAttribute('type',$page);

    }

    /** @test */
    public function it_should_add_select_properties_to_created_page_and_option()
    {

        $page = NotionPageFactory::createNotionPageWithSelectProperties();
        $this->assertCount(2,$page->getProperties());
        $this->assertObjectHasAttribute('properties',$page);


    }
    /** @test */
    public function it_should_add_multiselect_properties_to_created_page_and_option()
    {

        $page = NotionPageFactory::createNotionPageWithMultiSelectProperties();
        $this->assertCount(3,$page->getProperties());
        $this->assertObjectHasAttribute('properties',$page);


    }
    /** @test */
    public function it_can_add_content_blocks_to_created_pages()
    {
        $page = NotionPageFactory::addContentToCreatedPages();
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
