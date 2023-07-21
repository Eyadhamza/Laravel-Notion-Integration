<?php

return [
    'token' => env('NOTION_TOKEN'),
    'watcher' => [
        'target_database_id' => '02758e48d12244f99552dd4f766a0077',
        'webhook_route_name' => 'notion.webhook',
        'polling_interval_in_minutes' => 1,
    ]
];
