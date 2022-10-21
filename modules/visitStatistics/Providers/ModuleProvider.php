<?php

namespace Modules\visitStatistics\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadMigrationsFrom(base_path('modules/visitStatistics/database/migrations'));

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
