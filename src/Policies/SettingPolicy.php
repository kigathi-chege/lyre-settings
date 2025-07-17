<?php

namespace Lyre\Settings\Policies;

use Lyre\Settings\Models\Setting;
use Lyre\Policy;

class SettingPolicy extends Policy
{
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }
}
