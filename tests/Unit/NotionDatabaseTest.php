<?php

namespace Pi\Notion\Tests\Unit;

use Pi\Notion\NotionDatabase;

use Pi\Notion\NotionPage;
use Pi\Notion\Tests\TestCase;
use Pi\Notion\Workspace;

class NotionDatabaseTest extends TestCase
{

    /** @test */
    public function it_returns_new_database_instance()
    {
        $database = new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c');

        $this->assertInstanceOf(NotionDatabase::class, $database);

        $r = NotionDatabase::ofId('632b5fb7e06c4404ae12065c48280e4c');
        $this->assertStringContainsString('database',$r['object']);


    }

}
