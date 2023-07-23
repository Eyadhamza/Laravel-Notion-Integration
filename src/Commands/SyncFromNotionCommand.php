<?php

namespace PISpace\Notion\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use PISpace\Notion\Core\Models\NotionDatabase;

class SyncFromNotionCommand extends Command
{
    public $signature = 'sync:from-notion {model} {databaseId?} {pages?}';

    public $description = 'sync data from notion database to your app database';


    public function handle(): void
    {
        $model = $this->argument('model');

        $model = new $model;

        $this->validateIsModel($model);

        $pages = NotionDatabase::find($this->argument('databaseId'))
            ->query(50)
            ->getAllResults();

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

    private function validateIsModel(mixed $model): void
    {
        if (!$model instanceof Model) {
            $this->error('Model must be an instance of ' . Model::class);
        }
    }
}
