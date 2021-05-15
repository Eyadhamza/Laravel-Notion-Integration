<?php

namespace Pi\Notion;

use Pi\Notion\Commands\NotionCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NotionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('notion-wrapper')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_notion-wrapper_table')
            ->hasCommand(NotionCommand::class);
    }
}
