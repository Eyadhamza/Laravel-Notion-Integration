<?php

namespace Pi\Notion\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Pi\Notion\Core\NotionDatabase;

class SyncFromNotionCommand extends Command
{
    public $signature = 'from-notion:sync {databaseId} {model}';

    public $description = 'sync data from notion database to your app database';


    public function handle()
    {
        $paginator = NotionDatabase::find($this->argument('databaseId'))
            ->query(50);
        $model = $this->argument('model');
        $model = new $model;
        if (!$model instanceof Model) {
            $this->error('Model must be an instance of ' . Model::class);
        }
//        $this->info('Syncing ' . $paginator->getResults()->count() . ' records from ' . $this->argument('databaseId') . ' to ' . $model->getTable());



        $chunks = array_chunk($paginator->getAllResults()->toArray(), 50);
        foreach ($chunks as $chunk) {
            // we have chunk of data, now we need to map it to our model
            // we need to reverse map to notion method!
            $model::insert($chunk);
            $this->info('Synced ' . $model->count() . ' records');
        }
    }
}
