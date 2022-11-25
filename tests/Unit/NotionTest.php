<?php

namespace Pi\Notion\Tests\Unit;

use Pi\Notion\Core\NotionWorkspace;
use Pi\Notion\Tests\TestCase;

class NotionTest extends TestCase
{
    /** @test */
    public function it_returns_new_workspace_instance()
    {
        $workspace = new NotionWorkspace;

        $this->assertInstanceOf(NotionWorkspace::class, $workspace);
    }


}
