<?php

namespace Modules\note\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\note\Repository\EloquentNoteRepository;
use Modules\note\Repository\NoteRepositoryInterface;


class ModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NoteRepositoryInterface::class,EloquentNoteRepository::class);
        $this->loadMigrationsFrom(base_path('modules/note/database/migrations'));
        require_once base_path('modules/note/helpers.php');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        add_panel_child_menu([
            'label'=>'یادداشت‌ها',
            'access'=>'official',
            'url'=>url('note'),
            'parent_menu'=>'official'
        ]);
    }
}
