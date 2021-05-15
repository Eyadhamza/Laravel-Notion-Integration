<?php

namespace Pi\Notion\Tests\Unit;

use Pi\Notion\NotionDatabase;

use Pi\Notion\NotionPage;
use Pi\Notion\Tests\TestCase;
use Pi\Notion\Workspace;

class NotionTest extends TestCase
{
    /** @test */
    public function it_returns_new_workspace_instance()
    {
        $workspace = new Workspace;

        $this->assertInstanceOf(Workspace::class, $workspace);
    }

    /** @test */
    public function it_returns_new_database_instance()
    {
        $database = new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c');

        $this->assertInstanceOf(NotionDatabase::class, $database);
    }

    /** @test */
    public function it_returns_new_page_instance()
    {
        $page = new NotionPage('834b5c8cc1204816905cd54dc2f3341d');


        $this->assertInstanceOf(NotionPage::class, $page);
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
