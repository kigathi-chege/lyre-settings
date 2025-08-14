<?php

namespace Lyre\Settings\Filament\Plugins;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Lyre\Settings\Filament\Resources\SettingResource;

class LyreSettingsFilamentPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'lyre.settings';
    }

    public function register(Panel $panel): void
    {
        $resources = get_filament_resources_for_namespace('Lyre\\Settings\\Filament\\Resources');
        $panel
            ->resources($resources)
            ->userMenuItems([
                \Filament\Navigation\MenuItem::make()
                    ->label('Settings')
                    ->hidden(function () use ($panel) {
                        try {
                            SettingResource::getUrl(panel: $panel->getId());
                            return false;
                        } catch (\Throwable $e) {
                            return true;
                        }
                    })
                    ->url(function () use ($panel) {
                        try {
                            return SettingResource::getUrl(panel: $panel->getId());
                        } catch (\Throwable $e) {
                            logger()->warning("Settings menu not shown for panel [{$panel->getId()}]: {$e->getMessage()}");
                            return null;
                        }
                    })
                    ->icon('heroicon-o-cog-6-tooth'),
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
