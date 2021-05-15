<?php

namespace Pi\Notion\Tests\Featured;

use Pi\Notion\NotionDatabase;

use Pi\Notion\Exceptions\NotionDatabaseException;
use Pi\Notion\Tests\TestCase;
use Pi\Notion\Workspace;

class NotionApiTest extends TestCase
{
    /** @test */
    public function it_should_return_database_info()
    {
        $response =  (new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c'))->get();

        $this->assertStringContainsString('database',$response['object']);

        $response =  (new NotionDatabase)->get('632b5fb7e06c4404ae12065c48280e4c');

        $this->assertStringContainsString('database',$response['object']);

        $this->assertStringNotContainsString('error',$response['object']);
    }

    /** @test */
    public function it_should_throw_error_database_not_found()
    {
        $id = '632b5fb7e06c4404ae12asdasd065c48280e4asdc';

        $this->expectException(NotionDatabaseException::class);
        $response =  (new NotionDatabase($id))->get();


    }

}
