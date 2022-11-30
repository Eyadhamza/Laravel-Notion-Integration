<?php

namespace Pi\Notion\Tests\Unit;

use Pi\Notion\NotionClient;
use Pi\Notion\Tests\TestCase;

class NotionTest extends TestCase
{
    /** @test */
    public function it_returns_new_workspace_instance()
    {
        $workspace = new NotionClient;

        $this->assertInstanceOf(NotionClient::class, $workspace);
    }


}
