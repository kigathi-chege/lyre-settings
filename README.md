# Lyre Settings

`lyre/settings` provides tenant-aware key/value settings management for Lyre applications.

## Install
```bash
composer require lyre/settings
```

Publish migrations and migrate:
```bash
php artisan vendor:publish --provider="Lyre\Settings\Providers\LyreSettingsServiceProvider"
php artisan migrate
```

## Usage
Helper:
```php
setting('site_name');
```

Set values:
```php
\Lyre\Settings\Models\Setting::set('site_name', 'Giggle');
```

Get values:
```php
\Lyre\Settings\Models\Setting::get('site_name', 'Default');
```

## Filament
```php
use Lyre\Settings\Filament\Plugins\LyreSettingsFilamentPlugin;

$panel->plugins([
    LyreSettingsFilamentPlugin::make(),
]);
```

## Notes
- Settings are tenant-scoped when a tenant is bound by `tenant()`.
- Route file exists but currently has no API routes defined.
