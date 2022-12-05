<?php

namespace Pi\Notion\Tests\Featured;

use Illuminate\Support\Facades\Artisan;
use Pi\Notion\Core\NotionDatabase;
use Pi\Notion\Core\NotionFilter;
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

        Artisan::call('sync:to-notion', [
            'model' => User::class
        ]);
        // test artisan command
        $this->assertEquals(5, User::count());

    }
    public function test_map_notion_database_to_app_database_using_database_id()
    {
        Artisan::call('sync:from-notion',[
            'model' => User::class,
            'databaseId' => '74dc9419bec24f10bb2e65c1259fc65a'
        ]);
        $this->assertGreaterThan(80, User::count());
    }
    public function test_map_notion_database_to_app_database_using_specified_pages()
    {

        Artisan::call('sync:from-notion',[
            'model' => User::class,
            'pages' => NotionDatabase::find('74dc9419bec24f10bb2e65c1259fc65a')->filters([
                NotionFilter::title('Name')->contains('John')
            ])->query()->getAllResults()
        ]);
        $this->assertGreaterThan(10, User::count());
    }
}
