<?php

namespace Pi\Notion\Tests\Featured;

use Pi\Notion\NotionPage;
use Pi\Notion\Tests\Setup\NotionPageFactory;
use Pi\Notion\Tests\TestCase;

class ManageNotionPageTest extends TestCase
{
    private NotionPageFactory $notionPageFactory;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->notionPageFactory = new NotionPageFactory();
    }

    /** @test */
    public function it_should_return_page_info()
    {
        $this->withoutExceptionHandling();

        $object = $this->notionPageFactory->getAnExistingPage();

        $this->assertArrayHasKey('object', $object);


    }

    /** @test */
    public function i_can_create_a_page_object()
    {
        $page = $this->notionPageFactory->createNotionPage();
        $this->assertObjectHasAttribute('type', $page);

    }

    /** @test */
    public function it_should_add_properties_to_created_page_using_page_class()
    {
        $page = $this->notionPageFactory->createNotionPageWithPropertiesUsingPage();

        $this->assertCount(7, $page->getProperties());

        $this->assertObjectHasAttribute('properties', $page);
    }

    /** @test */
    public function it_should_update_properties_to_created_page_using_page_class()
    {
        $page = new NotionPage('b4f8e429038744ca9c8d5afa93ea2edd');
        $response = $page
            ->select('Status', 'In Progress')
            ->update();

        $this->assertObjectHasAttribute('properties', $page);
    }
    /** @test */
    public function it_should_add_properties_to_created_page()
    {
        $page = $this->notionPageFactory->createNotionPageWithPropertiesUsingPropertyClass();

        $this->assertCount(7, $page->getProperties());
        $this->assertObjectHasAttribute('properties', $page);
    }

    /** @test */
    public function it_can_add_content_blocks_to_created_pages()
    {
        $page = $this->notionPageFactory->addContentToCreatedPages();
        $this->assertCount(2, $page->getProperties());
        $this->assertCount(5, $page->getBlocks());
        $this->assertObjectHasAttribute('properties', $page);


    }
    /** @test */
    public function it_can_add_content_blocks_to_created_pages_using_page_class()
    {
        $page = $this->notionPageFactory->addContentToCreatedPagesUsingPageClass();
        $this->assertCount(2, $page->getProperties());
        $this->assertCount(5, $page->getBlocks());
        $this->assertObjectHasAttribute('properties', $page);


    }
    /** @test */
    public function it_returns_search_result()
    {
        $response = (new NotionPage)
            ->search('Eyad');

        $this->assertArrayHasKey('object', $response);
    }


}
