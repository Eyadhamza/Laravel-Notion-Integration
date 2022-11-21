<?php

namespace Pi\Notion\Tests\Featured;

use Facades\Pi\Notion\Tests\Setup\NotionPageFactory;
use Pi\Notion\NotionPage;
use Pi\Notion\Tests\TestCase;

class ManageNotionPageTest extends TestCase
{


    /** @test */
    public function it_should_return_page_info()
    {
        $object = NotionPageFactory::getAnExistingPage();
        $this->assertArrayHasKey('object', $object);


    }

    /** @test */
    public function i_can_create_a_page_object()
    {
        $page = NotionPageFactory::createNotionPage();
        $this->assertObjectHasAttribute('type', $page);

    }

    /** @test */
    public function it_should_add_properties_to_created_page_using_page_class()
    {
        $page = NotionPageFactory::createNotionPageWithPropertiesUsingPage();
        $this->assertCount(7, $page->getProperties());
        $this->assertObjectHasAttribute('properties', $page);
    }


    /** @test */
    public function it_should_add_properties_to_created_page()
    {
        $page = NotionPageFactory::createNotionPageWithPropertiesUsingPropertyClass();

        $this->assertCount(7, $page->getProperties());
        $this->assertObjectHasAttribute('properties', $page);
    }

    /** @test */
    public function it_can_add_content_blocks_to_created_pages()
    {
        $page = NotionPageFactory::addContentToCreatedPages();
        $this->assertCount(2, $page->getProperties());
        $this->assertCount(5, $page->getBlocks());
        $this->assertObjectHasAttribute('properties', $page);


    }
    /** @test */
    public function it_can_add_content_blocks_to_created_pages_using_page_class()
    {
        $page = NotionPageFactory::addContentToCreatedPagesUsingPageClass();
        $this->assertCount(2, $page->getProperties());
        $this->assertCount(5, $page->getBlocks());
        $this->assertObjectHasAttribute('properties', $page);


    }
    /** @test */
    public function it_returns_search_result()
    {
        $page = (new NotionPage)
            ->search('New Media Article');

        $this->assertStringContainsString('list', $page['object']);
    }


}
