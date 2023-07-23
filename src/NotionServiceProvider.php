<?php

namespace PISpace\Notion;

use Illuminate\Support\Collection;
use PISpace\Notion\Commands\NotionDatabaseWatcher;
use PISpace\Notion\Commands\SyncFromNotionCommand;
use PISpace\Notion\Commands\SyncToNotionCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NotionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {

        $package
            ->name('notion-api-wrapper')
            ->hasConfigFile('notion-api-wrapper')
            ->hasMigration('create_notion-api-wrapper_table')
            ->hasCommands([
                SyncFromNotionCommand::class,
                SyncToNotionCommand::class,
                NotionDatabaseWatcher::class
            ]);
    }

}
