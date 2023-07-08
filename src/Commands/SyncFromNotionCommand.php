<?php

namespace Pi\Notion\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Pi\Notion\Core\Models\NotionDatabase;

class SyncFromNotionCommand extends Command
{
    public $signature = 'sync:from-notion {model} {pages?}';

    public $description = 'sync data from notion database to your app database';


    public function handle()
    {
        $model = $this->argument('model');
        $model = new $model;

        if (!$model instanceof Model) {
            $this->error('Model must be an instance of ' . Model::class);
        }
        $pages = new Collection();
        $this->argument('pages') ?
            $pages = $this->argument('pages') :
            $pages = NotionDatabase::find($this->argument('databaseId'))
                ->query(50)->getAllResults();

        $pagesAsAttributes = [];
        foreach ($pages as $page) {
            $pagesAsAttributes[] = $model->mapFromNotion($page);
        }
        $chunks = array_chunk($pagesAsAttributes, 50);
        foreach ($chunks as $chunk) {
            $model::insert($chunk);
            $this->info('Synced ' . $model->count() . ' records');
        }
    }
}
