<?php

use Illuminate\Support\Facades\Artisan;
use Pi\Notion\Core\Models\NotionDatabase;
use Pi\Notion\Core\Query\NotionFilter;
use Pi\Notion\Tests\Models\User;

test('user creation', function () {
    $user = User::query()->create([
        'name' => 'John Doe',
        'email' => 'JohnDoe@gmail.com',
        'password' => 'password'
    ]);
    $user->saveToNotion();

    expect($user)->not()->toBeNull();
    expect(User::count())->toBe(1);
    expect($user->saveToNotion()->getProperties())->toHaveCount(3);
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
        'databaseId' => '74dc9419bec24f10bb2e65c1259fc65a'
    ]);

    expect(User::count())->toBeGreaterThan(80);
});

test('map Notion database to app database using specified pages', function () {
    $database = NotionDatabase::find('74dc9419bec24f10bb2e65c1259fc65a');
    $pages = $database->filters([
        NotionFilter::title('Name')->contains('John')
    ])->query()->getAllResults();

    Artisan::call('sync:from-notion', [
        'model' => User::class,
        'pages' => $pages
    ]);

    expect(User::count())->toBeGreaterThan(10);
});
