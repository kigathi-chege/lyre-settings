<?php

namespace Lyre\Settings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
}
