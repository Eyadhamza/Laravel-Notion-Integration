<?php

namespace Pi\Notion\Tests\Unit;

use Pi\Notion\NotionClient;
use Pi\Notion\Tests\TestCase;

class NotionWorkspaceTest extends TestCase
{

    /** @test */
    public function it_returns_new_database_instance()
    {
        $workspace = NotionClient::client();
        $this->assertInstanceOf(NotionClient::class, $workspace);
    }

}
