<?php

return [
    'token' => env('NOTION_TOKEN'),
    'watcher' => [
        'webhook_route_name' => 'notion.webhook',
        'polling_interval_in_minutes' => 1,
    ]
];
