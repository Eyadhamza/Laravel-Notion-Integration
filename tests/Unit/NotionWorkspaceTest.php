<?php

namespace Pi\Notion\Tests\Unit;

use Pi\Notion\Core\NotionDatabase;
use Pi\Notion\Core\NotionWorkspace;
use Pi\Notion\Tests\TestCase;

class NotionWorkspaceTest extends TestCase
{

    /** @test */
    public function it_returns_new_database_instance()
    {
        $workspace = NotionWorkspace::workspace();
        $this->assertInstanceOf(NotionWorkspace::class, $workspace);
    }

}
