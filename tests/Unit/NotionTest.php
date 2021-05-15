<?php

namespace Pi\Notion\Tests\Unit;

use Pi\Notion\NotionDatabase;

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
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
