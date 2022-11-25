<?php

namespace Pi\Notion\Tests\Unit;

use Pi\Notion\Core\NotionDatabase;
use Pi\Notion\Tests\TestCase;

class PageTest extends TestCase
{

    /** @test */
    public function it_returns_new_database_instance()
    {
        $database = new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c');
        $this->assertInstanceOf(NotionDatabase::class, $database);


    }


}
