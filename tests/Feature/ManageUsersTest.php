<?php

use Pi\Notion\Core\Models\NotionUser;

it('returns all users', function () {
    $users = NotionUser::make()->index();

    expect($users->getResults())->toHaveCount(3);
});

it('returns a user', function () {
    $user = NotionUser::make('2c4d6a4a-12fe-4ce8-a7e4-e3019cc4765f')->find();

    expect($user)->toHaveProperty('id');
});

it('returns a bot', function () {
    $bot = NotionUser::make()->findBot();

    expect($bot)->toHaveProperty('name');
});
