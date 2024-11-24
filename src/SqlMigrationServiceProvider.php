<?php

namespace BakkahIT\SqlMigration;

use Illuminate\Support\ServiceProvider;
use BakkahIT\SqlMigration\Commands\MakeSqlMigrationCommand;

class SqlMigrationServiceProvider  extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            MakeSqlMigrationCommand::class,
        ]);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
