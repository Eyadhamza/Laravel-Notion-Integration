<?php

namespace Pi\Notion\Tests\Featured;

use Pi\Notion\Core\NotionUser;
use Pi\Notion\Tests\TestCase;

class ManageUsersTest extends TestCase
{
    /** @test */
    public function it_returns_all_users()
    {
        $users = NotionUser::index();
        $this->assertCount(3, $users->getResults());
    }

    /** @test */
    public function it_returns_a_user()
    {

       $user = NotionUser::find('2c4d6a4a-12fe-4ce8-a7e4-e3019cc4765f');
       $this->assertObjectHasAttribute('id', $user);
    }
    /** @test */
    public function it_returns_a_bot()
    {
        $bot = NotionUser::getBot();
        $this->assertObjectHasAttribute('name', $bot);
    }


}
