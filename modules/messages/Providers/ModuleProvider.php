<?php

namespace Modules\messages\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\messages\Repository\EloquentMessageRepository;
use Modules\messages\Repository\MessageRepositoryInterface;
use View;
use Auth;
class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MessageRepositoryInterface::class,EloquentMessageRepository::class);
        $this->loadMigrationsFrom(base_path('modules/messages/database/migrations'));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        add_panel_child_menu([
            'label'=>'پیام‌ها',
            'access'=>'official',
            'url'=>url('messages'),
            'parent_menu'=>'official'
        ]);

    }
}
