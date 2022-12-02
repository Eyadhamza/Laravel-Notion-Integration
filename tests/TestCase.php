<?php

namespace Pi\Notion\Tests;

use Dotenv\Dotenv;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;
use Orchestra\Testbench\TestCase as Orchestra;
use Pi\Notion\NotionServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        if (file_exists(dirname(__DIR__) . '/.env.test')) {
            (Dotenv::createImmutable(dirname(__DIR__), '.env.test'))->load();
        }
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        $this->artisan('migrate', ['--database' => 'testbench'])
            ->run();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Pi\\Notion\\NotionDatabase\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            NotionServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
