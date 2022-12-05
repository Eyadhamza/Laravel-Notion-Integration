<?php

namespace Pi\Notion\Tests\Featured;

use Illuminate\Support\Facades\Artisan;
use Pi\Notion\Core\NotionDatabase;
use Pi\Notion\Core\NotionUser;
use Pi\Notion\Tests\Models\User;
use Pi\Notion\Tests\TestCase;

class ManageMappingTest extends TestCase
{
    public function test_user_creation()
    {
        $user = User::query()->create([
            'name' => 'John Doe',
            'email' => 'JohnDoe@gmail.com',
            'password' => 'password'
        ]);
        $user->saveToNotion();
        $this->assertNotNull($user);
        $this->assertEquals(1, User::count());
        $this->assertCount(3, $user->saveToNotion()->getProperties());
    }

    public function test_mapping_existing_database_to_notion()
    {
        $users = User::factory()->count(5)->create();

        Artisan::call('to-notion:sync', [
            'model' => User::class
        ]);
        // test artisan command
        $this->assertEquals(5, User::count());

    }
    public function test_map_notion_database_to_app_database_using_database_id()
    {
//        $paginator = NotionDatabase::find('74dc9419bec24f10bb2e65c1259fc65a')
//            ->query(50);
//
//        $this->assertCount(50, $paginator->getResults());
        Artisan::call('from-notion:sync',[
            'model' => User::class,
            'databaseId' => '74dc9419bec24f10bb2e65c1259fc65a'
        ]);

    }
}
