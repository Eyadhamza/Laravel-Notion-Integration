<?php

use Illuminate\Support\Facades\Artisan;
use Pi\Notion\Core\Models\NotionDatabase;
use Pi\Notion\Core\NotionProperty\NotionTitle;
use Pi\Notion\Core\Query\NotionFilter;
use Pi\Notion\Tests\Models\User;


test('user creation', function () {
    $user = User::query()->create([
        'name' => 'John Doe',
        'email' => 'JohnDoe@gmail.com',
        'password' => 'password'
    ]);
    $page = $user->saveToNotion();
    expect($user)->not()->toBeNull()
        ->and(User::count())->toBe(1);
});

test('mapping existing database to Notion', function () {
    $users = User::factory()->count(5)->create();

    Artisan::call('sync:to-notion', [
        'model' => User::class
    ]);

    expect(User::count())->toBe(5);
});

test('map Notion database to app database using database id', function () {
    Artisan::call('sync:from-notion', [
        'model' => User::class,
        'databaseId' => '6c0d2aa7cfbb46c2af06e9a63301e5fa'
    ]);

    expect(User::count())->toBeGreaterThan(80);
})->skip();

test('map Notion database to app database using specified pages', function () {
    $pages = NotionDatabase::make()->setFilters([
        NotionTitle::make('Name')->contains('John')
    ])
        ->query('74dc9419bec24f10bb2e65c1259fc65a')
        ->getAllResults();

    Artisan::call('sync:from-notion', [
        'model' => User::class,
        'pages' => $pages
    ]);

    expect(User::count())->toBeGreaterThan(10);
})->skip();
