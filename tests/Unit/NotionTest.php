<?php

namespace Pi\Notion\Tests\Unit;

use Pi\Notion\NotionDatabase;

use Pi\Notion\NotionPage;
use Pi\Notion\Tests\TestCase;
use Pi\Notion\NotionWorkspace;

class NotionTest extends TestCase
{
    /** @test */
    public function it_returns_new_workspace_instance()
    {
        $workspace = new NotionWorkspace;

        $this->assertInstanceOf(NotionWorkspace::class, $workspace);
    }


}
