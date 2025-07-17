<?php

namespace Lyre\Settings\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LyreSettingsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        register_repositories($this->app, 'Lyre\\Settings\\Repositories', 'Lyre\\Settings\\Contracts');
    }

    public function boot(): void
    {
        register_global_observers("Lyre\\Settings\\Models");

        $this->publishesMigrations([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }
}
