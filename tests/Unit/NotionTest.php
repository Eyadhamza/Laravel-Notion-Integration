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


}
