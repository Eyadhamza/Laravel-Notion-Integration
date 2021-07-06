<?php

namespace Pi\Notion;

use Illuminate\Support\Collection;
use Pi\Notion\Commands\NotionCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NotionServiceProvider extends PackageServiceProvider
{
    public function register()
    {
        $this->app->bind('notion-page', function($app) {
            return new NotionPage();
        });

        return parent::register();
    }

    public function configurePackage(Package $package): void
    {

        $package
            ->name('notion-wrapper')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_notion-wrapper_table')
            ->hasCommand(NotionCommand::class);
    }

    public function boot()
    {
         parent::boot();

        Collection::macro('toAssoc', function () {
            return $this->reduce(function ($assoc, $keyValuePair) {
                list($key, $value) = $keyValuePair;
                $assoc[$key] = $value;
                return $assoc;
            }, new static);
        });

        Collection::macro('mapToAssoc', function ($callback) {
            return $this->map($callback)->toAssoc();
        });
    }

}
