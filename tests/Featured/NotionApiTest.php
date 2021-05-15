<?php

namespace Pi\Notion\Tests\Featured;

use Pi\Notion\Database;

use Pi\Notion\Tests\TestCase;
use Pi\Notion\Workspace;

class NotionApiTest extends TestCase
{
    /** @test */
    public function it_should_return_database_info()
    {
        (new Database('632b5fb7e06c4404ae12065c48280e4c'))->get();
    }
}
