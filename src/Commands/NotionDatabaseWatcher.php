<?php

namespace Pi\Notion\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Pi\Notion\Core\Models\NotionDatabase;
use Pi\Notion\Core\Models\NotionPage;
use Pi\Notion\Core\Properties\NotionCreatedTime;
use Pi\Notion\Core\Resources\NotionPageResource;

class NotionDatabaseWatcher extends Command
{
    public $signature = 'notion:watch';

    public $description = 'watch notion database for changes';
    private string $databaseId;
    private int $pollingInterval;
    private string $route;
    public function __construct()
    {
        parent::__construct();
        $this->databaseId = config('notion-api-wrapper.watcher.target_database_id');
        $this->pollingInterval = config('notion-api-wrapper.watcher.polling_interval_in_minutes');
        $this->route = config('notion-api-wrapper.watcher.webhook_route_name');
    }

    public function handle(): void
    {
        $results = NotionDatabase::make($this->databaseId)
            ->setFilter(NotionCreatedTime::make()->onOrAfter(now()->subMinutes($this->pollingInterval)))
            ->query()
            ->getResults();

        if ($results->isNotEmpty()){
            Http::post(route($this->route), [
                'pages' => $results->map(fn(NotionPage $page) => NotionPageResource::make($page)->resolve()),
            ]);
        }

    }
}
