<?php

namespace PISpace\Notion\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SyncToNotionCommand extends Command
{
    public $signature = 'sync:to-notion {model}';

    public $description = 'sync your database to notion';


    public function handle()
    {
        $model = $this->argument('model');
        $model = new $model;
        if (!$model instanceof Model) {
            $this->error('Model must be an instance of ' . Model::class);
            return;
        }
        $this->info('Syncing ' . $model->getTable() . ' to ' . $model->getNotionDatabaseId());
        $model->chunk(100, function (Collection $models) {
            $models->each(function (Model $model) {
                $model->saveToNotion();
            });
            $this->info('Synced ' . $models->count() . ' records');
        });
    }
}
