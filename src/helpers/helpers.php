<?php

if (!function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        return \Lyre\Settings\Models\Setting::get($key, $default);
    }
}
