<?php

namespace Lyre\Settings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Lyre\Model;

class Setting extends Model
{
    use HasFactory;

    protected $casts = [
        'attributes' => 'array',
    ];

    public static function get($key, $default = null)
    {
        return self::where('key', $key)->first()->value ?? $default;
    }

    public static function set($key, $value)
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public function generateValue(): ?string
    {
        $attributes = json_decode($this->attributes['attributes']);

        $generator = data_get($attributes, 'generator');
        $generatorParams = data_get($attributes, 'generatorParams', []);

        if (! $generator) {
            return null;
        }

        $params[] = $generatorParams;
        $params[] = $this;

        if (is_callable($generator)) {
            return call_user_func($generator, ...$params);
        }

        // Allow `ClassName@method` or `ClassName::method` formats
        if (Str::contains($generator, '@')) {
            [$class, $method] = explode('@', $generator);
            return app($class)->{$method}(...$params);
        }

        if (Str::contains($generator, '::')) {
            return call_user_func($generator, $params);
        }

        throw new \RuntimeException("Invalid generator reference: {$generator}");
    }
}
